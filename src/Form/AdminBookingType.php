<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Anonce;
use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminBookingType extends AbstractType
{

    public function getConfiguration($label,$placeholder,$options=[]){
        return array_merge_recursive([
            'label'=>$label,'attr'=>[
                'placeholder'=>$placeholder
            ]],$options);

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',DateType::class,$this->getConfiguration("Date d'arrivée","Date d'arrivée à l'Airbnb",['widget'=>'single_text']))
            ->add('endDate',DateType::class,$this->getConfiguration("Date de départ","Date de Départ à l'Airbnb",['widget'=>'single_text']))
            ->add('comment',TextareaType::class,$this->getConfiguration("Commentaire","Veuillez donner le commentaire fait par l'utilisateur"))
            ->add('booker',EntityType::class,['class'=>User::class
            ,'choice_label'=>function($user){
                return $user->getPrenom()." ".strtoupper($user->getNom());
            }
            ])
            ->add('ad',EntityType::class,['class'=>Anonce::class,
            'choice_label'=>'titre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
