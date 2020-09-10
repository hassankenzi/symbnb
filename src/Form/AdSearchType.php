<?php

namespace App\Form;

use App\Entity\AdSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minPrice',NumberType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budger min'
                ]
            ])
            ->add('maxPrice',NumberType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budger max'
                ]
            ])
            ->add('city',TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'ville'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdSearch::class,
            'method'  => 'get',
            'csrf_protection' => false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
