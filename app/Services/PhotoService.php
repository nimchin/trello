<?php


namespace App\Services;


class PhotoService
{
    const DRIVERS = [
        'intervention', 'imagick'
    ];

    protected $width = 300;

    protected $height = 300;

    private $driver;

    public function __construct()
    {
        $this->driver = config('drivers.image_driver');
    }

    public function crop()
    {
        return $this->driver;
    }


}
