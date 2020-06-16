<?php

namespace App\Form;

use App\Entity\AlertMeteo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlerteMeteoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('online', ChoiceType::class, [
                'label' => 'En ligne',
                'choices' =>[
                    'Oui' => true,
                    'Non' => false
                ]
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Niveau de vigilance',
                'choices' =>[
                    'Vert' => 1,
                    'Jaune' => 2,
                    'Orange' => 3,
                    'Rouge' => 4
                ]
            ])
            ->add('message')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AlertMeteo::class,
        ]);
    }
}
