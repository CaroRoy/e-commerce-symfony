<?php

namespace App\MesServices\ImageServices;


class CreateImageService {
    public function createImage(?object $image, string $pathToDirectory, object $entity) {
        if ($image !== null) {
            $file = md5(uniqid()) . '.' . $image->guessExtension();

            $image->move($pathToDirectory, $file);

            $entity->setImageUrl('/uploads/' . $file);
        }
    }
}