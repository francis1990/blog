<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function store(UploadedFile $image, string $path, string $name): string
    {
        $extension = $image->getClientOriginalExtension();
        $nameFile = $name . '.' . $extension;

        while (Storage::exists("$path/$nameFile")) {
            $nameFile = str_replace(".$extension", "-copy.$extension", $nameFile);
        }

        return Storage::putFileAs($path, $image, $nameFile);
    }

    public function delete(?string $imagePath): void
    {
        if ($imagePath && Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }
}
