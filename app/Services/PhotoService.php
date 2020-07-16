<?php


namespace App\Services;


use Imagick;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class PhotoService
{
    const DRIVERS = [
        // Add new image drivers here
        'intervention' => 'intervention',
        'imagick' => 'imagick',
    ];

    const PHOTO_WIDTH = [
        'mobile' => 320,
        'desktop' => 1024,
    ];

    const PHOTO_HEIGHT = [
        'mobile' => 480,
        'desktop' => 720,
    ];

    private $driver;

    public function __construct()
    {
        $this->driver = config('drivers.image_driver');
    }

    /**
     * @param $imgPath
     * @param $imgName
     * @param $croppingFormat
     * @throws \ImagickException
     */
    public function crop($imgPath, $imgName)
    {
        if(!is_dir("$imgPath". '/cropped')){
            mkdir("$imgPath". '/cropped',0777,true);
            mkdir("$imgPath". '/cropped/mobile',0777,true);
            mkdir("$imgPath". '/cropped/desktop',0777,true);
        }
        if($this->driver === self::DRIVERS['imagick']){
            $image = new Imagick($imgPath . '/'. $imgName);
            //Mobile format
            $mobileImage = clone $image;
            $mobileImage->cropThumbnailImage(self::PHOTO_WIDTH['mobile'], self::PHOTO_HEIGHT['mobile']);
            $mobileImage->writeImageFile(fopen ($imgPath."/cropped/mobile/" . $imgName, "wb"));
            //Desktop format
            $image->cropThumbnailImage(self::PHOTO_WIDTH['desktop'], self::PHOTO_HEIGHT['desktop']);
            $image->writeImageFile(fopen ($imgPath."/cropped/desktop/" . $imgName, "wb"));
        } else if($this->driver === self::DRIVERS['intervention']) {
            $image = Image::make($imgPath . '/'. $imgName);
            //Mobile format
            $mobileImage = clone $image;
            $mobileImage->crop(self::PHOTO_WIDTH['mobile'], self::PHOTO_HEIGHT['mobile']);
            $mobileImage->save(public_path(). '/images/cropped/mobile/'. $imgName);
            //Desktop format
            $image->crop(self::PHOTO_WIDTH['desktop'], self::PHOTO_HEIGHT['desktop']);
            $image->save(public_path() . '/images/cropped/desktop/' . $imgName);
        }
    }


}
