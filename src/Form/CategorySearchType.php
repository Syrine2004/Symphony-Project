<?php

namespace App\Form;

use App\Entity\Category; // <-- AJOUTE CE USE
use App\Entity\CategorySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // <-- AJOUTE CE USE
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [ // <-- AJOUTE CE CHAMP
                'class' => Category::class,
                'choice_label' => 'titre',
                'label' => 'Catégorie',
                'required' => false, // Important pour la recherche
                'placeholder' => 'Toutes les catégories' // Ajout utile
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorySearch::class, // <-- AJOUTE CETTE LIGNE
            'method' => 'GET', // On ajoute ça pour que la recherche passe par l'URL
        ]);
    }
}