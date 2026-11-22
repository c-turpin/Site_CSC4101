<?php

namespace App\Form;

use App\Entity\Bibliotheque;
use App\Entity\Jeu;
use App\Entity\Showcase;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Annee')
            ->add('Nom')
            ->add('bibliotheque', EntityType::class, [
                'class' => Bibliotheque::class,
                'choice_label' => 'id',
            ])
            ->add('showcases', EntityType::class, [
                'class' => Showcase::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
