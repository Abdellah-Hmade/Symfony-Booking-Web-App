<?php
namespace App\Form\DateTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchtoDate implements DataTransformerInterface {

    public function transform($date){
        if($date==null){
            return '';
        }
        return $date->formats('d/m/Y');
    }
    public function reverseTransform($frenchDate){
        if($frenchDate==null){
           throw new TransformationFailedException("Vous devez fournir une date !"); 
        }
        $date=\DateTime::createFromFormat('d/m/Y',$frenchDate);
        if($date===false){
            throw new TransformationFailedException("Le format de la date n'est pas le bon!");
        }
        return $date;
    }
}
?>