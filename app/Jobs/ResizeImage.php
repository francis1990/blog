<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $imagePath;
    protected $width;
    protected $height;

    public function __construct($imagePath, $width, $height)
    {
        $this->imagePath = $imagePath;
        $this->width = $width;
        $this->height = $height;
    }

    public function handle(): void
    {
        $upload = Storage::get('app/public/' . $this->imagePath);

        $extension = pathinfo($this->imagePath, PATHINFO_EXTENSION);
        
        $image = Image::read($upload)
            ->resize($this->width, $this->height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encodeByExtension($extension, qyality: 90);

        Storage::put($this->imagePath, $image);
    }
}
