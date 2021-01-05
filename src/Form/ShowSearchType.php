<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\ShowSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class,[
                "label" => false
            ])
            ->add('band', EntityType::class,[
                'class' => Band::class,
                'choice_label' => 'name',
                'multiple' => false,
                "label" => false

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShowSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
