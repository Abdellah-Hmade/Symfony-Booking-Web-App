<?php

namespace App\Form;

use App\Entity\Booking;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\DateTransformer\FrenchtoDate;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends AbstractType
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
    private $transformer;

    public function __construct(FrenchtoDate $transformer){
        $this->transformer=$transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',TextType::class,$this->getConfiguration("Date d'arrivée","La date dont vous comptez arriver"))
            ->add('endDate',TextType::class,$this->getConfiguration("Date de départ","La date dont vous comptez Sortir"))
            ->add('comment',TextareaType::class,$this->getConfiguration("Commentaire","Donner un commentaire sur cette annonce.",["required"=>false]))
        ;
        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'validation_groups'=>["Default","front"]
        ]);
    }
}
