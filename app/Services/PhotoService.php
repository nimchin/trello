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

    private $imagickPhotoService;

    private $interventionPhotoService;

    private $driver;

    public function __construct(
        ImagickPhotoService $imagickPhotoService,
        InterventionPhotoService $interventionPhotoService
    )
    {
        $this->driver = config('drivers.image_driver');
        $this->imagickPhotoService = $imagickPhotoService;
        $this->interventionPhotoService = $interventionPhotoService;
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
            $this->imagickPhotoService->cropForMobile($imgPath, $imgName);
            $this->imagickPhotoService->cropForDesktop($imgPath, $imgName);
        } else if($this->driver === self::DRIVERS['intervention']) {
            $this->interventionPhotoService->cropForMobile($imgPath, $imgName);
            $this->interventionPhotoService->cropForDesktop($imgPath, $imgName);
        }
    }


}
