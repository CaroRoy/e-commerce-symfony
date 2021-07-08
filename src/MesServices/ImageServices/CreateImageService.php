<?php

namespace App\MesServices\ImageServices;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;


// class CreateImageService {
//     public function createImage(?object $image, string $pathToDirectory, object $entity) {
//         if ($image !== null) {
//             $file = md5(uniqid()) . '.' . $image->guessExtension();

//             $image->move($pathToDirectory, $file);

//             $entity->setImageUrl('/uploads/' . $file);
//         }
//     }
// }

// ou mieux: avec le containerBag pour obtenir directement le chemin vers le dossier uploads :
class CreateImageService {

    protected $containerBag;

    // (il faut importer la class ContainerBagInterface sous le namespace) :
    public function __construct(ContainerBagInterface $containerBag) {
        $this->containerBag = $containerBag;
    }

    public function createImage(?object $image, object $entity) {
        if ($image !== null) {
            $file = md5(uniqid()) . '.' . $image->guessExtension();

            // on utilise le containerBag pour se faire livrer le service get qui permet d'utiliser le parameter qu'on a mis dans le fichier service.yaml :
            $image->move($this->containerBag->get('app_images_directory'), $file);

            $entity->setImageUrl('/uploads/' . $file);
        }
    }
}