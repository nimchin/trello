<?php


namespace App\Services;


use Imagick;

class PhotoService
{
    const DRIVERS = [
        // Add new image drivers here
        'intervention' => 1,
        'imagick' => 2,
    ];

    protected $width = 300;

    protected $height = 300;

    private $driver;

    public function __construct()
    {
        $this->driver = config('drivers.image_driver');
    }

    /**
     * @param $imgPath
     * @param $imgName
     * @throws \ImagickException
     */
    public function crop($imgPath, $imgName)
    {
        if((int)$this->driver === self::DRIVERS['imagick']){
            $imageImagick = new Imagick($imgPath . '/'. $imgName);
            $imageImagick->cropImage(200, 50, 0, 0);
            if(!is_dir("$imgPath". '/cropped')){
                mkdir("$imgPath". '/cropped',0777,true);
            }
            $imageImagick->writeImageFile(fopen ($imgPath."/cropped/test_2.jpg", "wb"));
        }

    }


}
