<?php


namespace App\Services;


use Intervention\Image\Facades\Image;

class InterventionPhotoService extends PhotoService implements \PhotoInterface
{

    /**
     * @param $imgPath
     * @param $imgName
     */
    public function cropForMobile($imgPath, $imgName)
    {
        $image = Image::make($imgPath . '/'. $imgName);
        $image->crop(self::PHOTO_WIDTH['mobile'], self::PHOTO_HEIGHT['mobile']);
        $image->save(public_path(). '/images/cropped/mobile/'. $imgName);
    }

    /**
     * @param $imgPath
     * @param $imgName
     */
    public function cropForDesktop($imgPath, $imgName)
    {
        $image = Image::make($imgPath . '/'. $imgName);
        $image->crop(self::PHOTO_WIDTH['desktop'], self::PHOTO_HEIGHT['desktop']);
        $image->save(public_path() . '/images/cropped/desktop/' . $imgName);
    }
}
