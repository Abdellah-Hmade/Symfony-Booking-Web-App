<?php

namespace App\Form;

use App\Entity\Anonce;

use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnonceType extends AbstractType
{
    /**
     * Configuration de base d'un champ !
     *
     * @param [string] $placeholder
     * @param [array] $options
     * @return array
     */
    public function getConfiguration($label,$placeholder,$options=[]){
        return array_merge_recursive(['label'=>$label,
            'attr'=>[
                'placeholder'=>$placeholder
            ]],$options);

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titre',TextType::class,$this->getConfiguration("Titre de l'Annonce","Tapez un titre pour votre annonce"))
        ->add('adresse',TextType::class,$this->getConfiguration("Adresse","Tapez l'adresse web (automatique)",['required'=>false]))
        ->add('chambres',IntegerType::class,$this->getConfiguration("Chmabres","Le nombre des Chambres"))
        ->add('coverImage',UrlType::class,$this->getConfiguration("Image principal","Donner l'adresse d'une image qui donne vraiment envie de venir chez vous"))
        ->add('prix',MoneyType::class,$this->getConfiguration("Prix par nuit","Indiquez le prix que vous voulez pour une nuit"))
        ->add('introduction',TextType::class,$this->getConfiguration("Introduction","Donnez une description globale de l'annonce"))
        ->add('content',TextareaType::class,$this->getConfiguration("Déscription","Tapez une description qui donne envis de venir chez vous !"))
        ->add('images',CollectionType::class,[
            'entry_type'=>ImageType::class,
            'allow_add'=>true,
            'allow_delete'=>true
        ])
        ->add('save',SubmitType::class,[
            'label'=>"Enregistrer l'annonce",
            'attr'=>[
                'class'=>'btn btn-primary',
                'type'=>'soumettre'
            ]
        ])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Anonce::class,
        ]);
    }
}
