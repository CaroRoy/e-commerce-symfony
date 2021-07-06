<?php

namespace App\MesServices\ImageServices;

class DeleteImageService {
    public function deleteImage(string $imageUrl, string $pathToDirectory) {
        if ($imageUrl !== null) {
            $fileImageOriginal = $pathToDirectory . '/..' . $imageUrl;

            if (file_exists($fileImageOriginal)) {
                unlink($fileImageOriginal);
            }
        }
    }
}