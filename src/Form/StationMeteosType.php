<?php

namespace App\Form;

use App\Entity\StationMeteos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StationMeteosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('ville')
            ->add('codepostal')
            ->add('gps_latitude')
            ->add('gps_longitude')
            ->add('filePhoto', VichImageType::class,[
                'required' => false,
                'download_link' => false,
                'image_uri' => false
            ])
            ->add('description', CKEditorType::class)
            ->add('diy', ChoiceType::class,[
                'choices' =>[
                    'Oui' => true,
                    'Non' => false
                ]
            ])
            ->add('user')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StationMeteos::class,
        ]);
    }
}
