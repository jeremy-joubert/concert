<?php

namespace App\Form;

use App\Entity\Band;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                "label" => 'Non du groupe'
            ])
            ->add('style', TextType::class,[
                "label" => 'Style de musique'
            ])
            ->add('picture', FileType::class,[
                "label" => 'Image du groupe'
            ])
            ->add('yearofcreation', DateType::class,[
                "label" => 'Date de création du groupe'
            ])
            ->add('lastalbumname', TextType::class,[
                "label" => 'Dernier album'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
