<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Hall;
use App\Entity\Show;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('band', EntityType::class,[
                'class' => Band::class,
                'choice_label' => 'name',
                'multiple' => false,
                "label" => 'Sélectionner le groupe'

            ])
            ->add('hall', EntityType::class,[
                'class' => Hall::class,
                'choice_label' => 'name',
                'multiple' => false,
                'label' => 'Sélectionner la salle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Show::class,
        ]);
    }
}
