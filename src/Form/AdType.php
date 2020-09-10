<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => "Tapez un super titre pour votre annonce !"
                ]
            ])
      
            ->add('introduction', TextType::class,[
                'label' => 'Introduction',
                'attr' => [
                    'placeholder' => "Donnez une description globale  del'annonce!"
                ]
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Description détaillée',
                'attr' => [
                    'placeholder' => "Tapez une description détaillée"
                ]
            ])
          
            ->add('coverImage', UrlType::class,[
                'label' => "URL de l'image principale",
                'attr' => [
                    'placeholder' => "Donnez une image pour l'annonce"
                ]
            ])
            ->add('rooms', IntegerType::class,[
                'label' => 'Nombre de chambres',
                'attr' => [
                    'placeholder' => "le nombre de chambres disponibles "
                ]
            ])
            ->add('price', MoneyType::class,[
                'label' => 'Prix par nuit',
                'attr' => [
                    'placeholder' => "Indiquez le prix que vous voulez pour une nuit"
                ]
            ])
            
            ->add('city', TextType::class,[
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => "Ville"
                ]
            ])
            ->add('postalCode', IntegerType::class,[
                'label' => 'code postaale',
                'attr' => [
                    'placeholder' => "code postale"
                ]
                ])

                ->add('imageFile', FileType::class,[
                    'required' => 'false'   
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
