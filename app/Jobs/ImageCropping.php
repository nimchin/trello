<?php

namespace App\Jobs;

use App\Services\PhotoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ImageCropping implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $imageName;

    private $imagePath;

    /**
     * Create a new job instance.
     * @param $imageName
     * @param $imagePath
     */
    public function __construct($imagePath, $imageName)
    {
        $this->imageName = $imageName;
        $this->imagePath = $imagePath;
    }

    /**
     * Execute the job.
     *
     * @param PhotoService $photoService
     * @return void
     * @throws \ImagickException
     */
    public function handle(PhotoService $photoService)
    {
        $photoService->crop($this->imagePath, $this->imageName);
    }
}
