<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->getConfiguration("Ancien mot de passs", "tappez Votre mot de passe actuel ..."))
            ->add('newPassword', PasswordType::class, $this->getConfiguration("Nouveau mot de passs", "tappez Votre nouveaumot de passe ..."))
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration("Confirmation de mot de passe mot de passs", "confirmez  Votre mot de passe ..."))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
