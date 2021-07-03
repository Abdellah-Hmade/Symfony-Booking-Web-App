<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends AbstractType
{
    /**
     * Configuration de base d'un champ !
     * @param [string] $label
     * @param [string] $placeholder
     * @param [array] $options
     * @return array
     */

    public function getConfiguration($label,$placeholder,$options=[]){
        return array_merge([
            'label'=>$label,'attr'=>[
                'placeholder'=>$placeholder
            ]],$options);

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',PasswordType::class,$this->getConfiguration("Ancien Mot de passe","Veuillez donner votre Ancien Mot de passe"))
            ->add('newPassword',PasswordType::class,$this->getConfiguration("Nouveau Mot de passe","Veuillez donner votre Nouveau Mot de passe"))
            ->add('confirmPassword',PasswordType::class,$this->getConfiguration("Confirmation du Mot de passe","Veuillez Confirmer le Nouveau Mot de passe saisie"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
