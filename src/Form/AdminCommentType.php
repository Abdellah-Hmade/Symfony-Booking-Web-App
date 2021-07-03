<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminCommentType extends AbstractType
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
