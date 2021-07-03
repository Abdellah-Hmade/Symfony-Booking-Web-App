<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Anonce;
use App\Form\AnonceType;
use App\Repository\AnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AnonceController extends AbstractController
{
    /**
     * @Route("/anonces", name="anonces_index")
     */
    public function index(AnonceRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Anonce::class);
        $Anonces=$repo->findAll();
        return $this->render('anonce/index.html.twig', [
            'Anonces' => $Anonces
        ]);
    }
/**
 * créer une annonce
 * 
 * @Route("/anonce/nouveau",name="anonces_create")
 * @IsGranted("ROLE_USER")
 * @return Response
 */
public function create(Request $request,EntityManagerInterface $manager){
    $anonce=new Anonce();
    $image=new Image();
     
    $form=$this->createForm(AnonceType::class,$anonce);
     $form->handleRequest($request);
     
     if($form->isSubmitted()&&$form->isValid()){
         
         foreach($anonce->getImages() as $image){
                $image->setAnonce($anonce);
                $manager->persist($image);
         }
         $anonce->setAuteur($this->getUser());
         $manager->persist($anonce);
         $manager->flush();
        $this->addFlash('success',"L'annonce <strong>".$anonce->getTitre()."</strong> est Bien enregistré.");
         return $this->redirectToRoute('anonce_show',['adresse'=>$anonce->getAdresse()]);
     }           
    return $this->render('anonce/nouveau.html.twig',[
        'form'=>$form->createView()
    ]);
    }

/**
 * @Route("/anonce/{adresse}",name="anonce_show")
 *
 * @return Response 
 */
public function  show(Anonce $anonce){
//$anonce=$repo->findOneByAdresse($adresse);
return $this->render('anonce/show.html.twig',[
    'anonce' => $anonce
]);
}
/**
 * afficher le formulaire d'edition
 * @Route("/anonce/{adresse}/editer",name="anonce_editer")
 *@Security("is_granted('ROLE_USER') and user === anonce.getAuteur()", message="Cette annonce ne vous appatient pas vous ne pouvez pas la modifier")
 */

 public function edit(Anonce $anonce,Request $request,EntityManagerInterface $manager){

    $form=$this->createForm(AnonceType::class,$anonce);
    $form->handleRequest($request);
     
    
    if($form->isSubmitted()&&$form->isValid()){
        
        foreach($anonce->getImages() as $image){
               $image->setAnonce($anonce);
               $manager->persist($image);
        }
        $manager->persist($anonce);
        $manager->flush();
       $this->addFlash('success',"les modifications de L'annonce <strong>".$anonce->getTitre()."</strong> ont Bien été enregistrées .");
        return $this->redirectToRoute('anonce_show',['adresse'=>$anonce->getAdresse()]);
    }    

    return $this->render("anonce/edit.html.twig",[
        'form'=>$form->createView(),
        'anonce'=>$anonce
    ]);
 }
/**
 * 
 * @Route("/anonce/{adresse}/delete",name="anonces_delete")
 * @Security("is_granted('ROLE_USER') and user === anonce.getAuteur()", message="Cette annonce ne vous appatient pas vous ne pouvez pas la modifier")
 * 
 * @param Anonce $anonce
 * @param EntityManagerInterface $manager
 * @return void
 */
 public function delete(Anonce $anonce,EntityManagerInterface $manager){
$manager->remove($anonce);
$manager->flush();
$this->addFlash('success',"L'annonce <strong>".$anonce->getTitre()."</strong> a été bien suprimée .");
return $this->redirectToRoute("anonces_index");
 
}

}
