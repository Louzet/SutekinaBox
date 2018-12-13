<?php

namespace App\Form;

use App\Entity\Box;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoxCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('image', FileType::class, [
                'attr' => [
                    'class' => 'dropify',
                    'data-default-file' => $options['image_url']
                ]
            ])
            ->add('price', TextType::class)
            ->add('Products', EntityType::class, [
                'class' => Product::class,
                'choice_label'  => 'title',
                'expanded'      => true,
                'multiple'      => true
            ])
            ->add('dateLivraison', DateType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Box::class,
            'image_url'  => null
        ]);
    }
}
