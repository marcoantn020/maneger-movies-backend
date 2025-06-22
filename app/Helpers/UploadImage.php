<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class UploadImage
{
    public static function execute(UploadedFile $file, string $directoryName, string $pathExclude = ''): bool|string
    {
        if ($pathExclude !== '') {
            Storage::disk('public')->delete($pathExclude);
        }

        $imagePath = $file->store($directoryName, 'public');
        return $imagePath ?? '';
    }
}
