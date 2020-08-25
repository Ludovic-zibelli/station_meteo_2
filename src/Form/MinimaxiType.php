<?php

namespace App\Form;

use App\Entity\MinimaxiSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MinimaxiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class,  array(
                'label' => 'Filtrer par date :',
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Cliquez-ICI',
                    'class' => 'js-pickadate-booking']))

            ->add('date_interval', DateType::class,  array(
                'label' => 'Filtrer par date :',
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Cliquez-ICI',
                    'class' => 'js-pickadate-booking']))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MinimaxiSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
