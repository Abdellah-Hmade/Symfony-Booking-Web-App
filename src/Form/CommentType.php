<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    /**
     * Configuration de base d'un champ !
     * @param [string] $label
     * @param [string] $placeholder
     * @param [array] $options
     * @return array
     */

    public function getConfiguration($label,$placeholder,$options=[]){
        return array_merge_recursive([
            'label'=>$label,'attr'=>[
                'placeholder'=>$placeholder
            ]],$options);

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating',IntegerType::class,$this->getConfiguration("Note sur 5","Veuillez indiquer votre note sur 5",['attr'=>[
                'min'=>0,
                'max'=>5,
                'step'=>1            
                ]]))
            ->add('content',TextareaType::class,$this->getConfiguration("Votre avis","veuillez être précis cela aidra nos prochain voyageur."))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
