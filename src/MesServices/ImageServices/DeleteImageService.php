<?php

namespace App\MesServices\ImageServices;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class DeleteImageService {

    protected $containerBag;

    public function __construct(ContainerBagInterface $containerBag) {
        $this->containerBag = $containerBag;
    }

    public function deleteImage(?string $imageUrl) {
        if ($imageUrl !== null) {
            $fileImageOriginal = $this->containerBag->get('app_images_directory') . '/..' . $imageUrl;

            if (file_exists($fileImageOriginal)) {
                unlink($fileImageOriginal);
            }
        }
    }
}