<?php


namespace App\Services;


use Imagick;

class ImagickPhotoService extends PhotoService implements \PhotoInterface
{

    /**
     * @param $imgPath
     * @param $imgName
     * @throws \ImagickException
     */
    public function cropForDesktop($imgPath, $imgName)
    {
        $image = new Imagick($imgPath . '/'. $imgName);
        $image->cropThumbnailImage(self::PHOTO_WIDTH['desktop'], self::PHOTO_HEIGHT['desktop']);
        $image->writeImageFile(fopen ($imgPath."/cropped/desktop/" . $imgName, "wb"));
    }

    /**
     * @param $imgPath
     * @param $imgName
     * @throws \ImagickException
     */
    public function cropForMobile($imgPath, $imgName)
    {
        $image = new Imagick($imgPath . '/'. $imgName);
        $image->cropThumbnailImage(self::PHOTO_WIDTH['mobile'], self::PHOTO_HEIGHT['mobile']);
        $image->writeImageFile(fopen ($imgPath."/cropped/mobile/" . $imgName, "wb"));
    }

}
