<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{

    public function getConfiguration($label,$options=[]){
        return array_merge_recursive([
            'label'=>$label,'attr'=>[

            ]],$options);

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('introduction',TextareaType::class,$this->getConfiguration("Introduction sur L'utilisateur"))
            ->add('description',TextareaType::class,$this->getConfiguration("Introduction sur L'utilisateur"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
