<?php

namespace App\Doctrine\Listener;

use App\Entity\Product;
use Symfony\Component\String\Slugger\SluggerInterface;

class EditProductSlugListener {
    protected $slugger;

    public function __construct(SluggerInterface $slugger) {
        $this->slugger = $slugger;
    }

    public function preUpdate(Product $entity) {
        $entity->setSlug(strtolower($this->slugger->slug($entity->getName())));
    }
}