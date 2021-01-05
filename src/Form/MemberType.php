<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                "label" => 'Nom'
            ])
            ->add('firstname', TextType::class,[
                "label" => 'Prénom'
            ])
            ->add('job', TextType::class,[
                "label" => 'Métier'
            ])
            ->add('birthdate', DateType::class,[
                "label" => 'Date de naissance'
            ])
            ->add('picture', FileType::class,[
                "label" => 'Photo'
            ])
            ->add('band', EntityType::class,[
                'class' => Band::class,
                'choice_label' => 'name',
                'multiple' => false,
                "label" => 'Sélectionner le groupe'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
