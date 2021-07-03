<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class RegistrationType extends AbstractType
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
            ->add('prenom',TextType::class,$this->getConfiguration("Prénom","Votre prénom ici"))
            ->add('nom',TextType::class,$this->getConfiguration("Nom","Votre Nom ici"))
            ->add('email',EmailType::class,$this->getConfiguration("Email","Votre adresse email "))
            ->add('avatar',UrlType::class,$this->getConfiguration("Photo de Profil","Votre Photo de profil ici "))
            ->add('hash',PasswordType::class,$this->getConfiguration("Mot de Passe","Choisissez un bon mot de passe "))
            ->add('PasswordConfirm',PasswordType::class,$this->getConfiguration("Confirmation du mot de passe","veuillez confirmer votre mot de passe"))
            ->add('introduction',TextType::class,$this->getConfiguration("Introduction","Présentez vous en quelques mots"))
            ->add('description',TextType::class,$this->getConfiguration("Description détaillée","Présentez vous en détaille"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
