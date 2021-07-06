<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom du produit'])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du produit',
                'currency' => 'EUR',
                'attr' => ['placeholder' => 'prix en €uros'],
                'divisor' => 100
            ])
            ->add('description', TextareaType::class, ['label' => 'Description du produit'])
            ->add('imageUrl', FileType::class, [
                'label' => 'Insérer une image',
                'mapped' => false,
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie du produit',
                // placeholder pas dans attr ici car ce sera dans un input select
                'placeholder' => '-- Choisir une catégorie --',
                'class' => Category::class,
                'choice_label' => function(Category $category) {
                    return strtoupper($category->getName());
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
