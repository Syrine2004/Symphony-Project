<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category; // <-- (TP6 ÉTAPE 9) AJOUTE CE USE
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // <-- (TP6 ÉTAPE 9) AJOUTE CE USE
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            
            // (TP6 ÉTAPE 9) AJOUTE CE CHAMP
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'titre',
                'label' => 'Catégorie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}