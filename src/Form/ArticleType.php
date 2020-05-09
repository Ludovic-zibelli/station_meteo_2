<?php

namespace App\Form;

use App\Entity\Arcticles;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('content', CKEditorType::class)
            ->add('auteur')
            ->add('online', ChoiceType::class, [
                'choices' =>[
                    'Oui' => true,
                    'Non' => false
                ]
            ])
            ->add('imageFile', VichImageType::class,[
                'required' => false,
                'download_link' => false,
                'image_uri' => false
            ])
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Arcticles::class,
        ]);
    }
}
