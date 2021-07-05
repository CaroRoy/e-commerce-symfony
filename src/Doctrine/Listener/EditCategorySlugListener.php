<?php

namespace App\Doctrine\Listener;

use App\Entity\Category;
use Symfony\Component\String\Slugger\SluggerInterface;

class EditCategorySlugListener {
    protected $slugger;

    public function __construct(SluggerInterface $slugger) {
        $this->slugger = $slugger;
    }

    public function preUpdate(Category $entity) {
        $entity->setSlug(strtolower($this->slugger->slug($entity->getName())));
    }
}