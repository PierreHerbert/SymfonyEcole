<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Eleves;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEleve')
            ->add('prenomEleve')
            ->add('dateNaissance', DateType::class , array(
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
              ))
            ->add('classeEleve', EntityType::class ,[
                'class' => Classes::class , 'choice_label' => 'nomClasse'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
