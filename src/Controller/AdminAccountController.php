<?php

namespace App\Controller;

use App\Entity\Anonce;
use App\Entity\Booking;
use App\Entity\Comment;

use App\Form\AnonceType;
use App\Form\AdminCommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();
        $username=$utils->getLastUsername();
        
        return $this->render('admin/account/login.html.twig', [
            'hasError'=>$error !==null,
            'username'=>$username
        ]);
    }

    /**
 * 
 * @Route("/admin/logout",name="admin_account_logout")
 * @return Response
 */
    public function logout(){


    }
/**
 * @Route("/admin/ads/{id}/edit" ,name="admin_ads_edit")
 *
 * @param Anonce $anonce
 * @return Response
 */
    public function editAd(Anonce $anonce ,Request $request,EntityManagerInterface $manager){
        $form=$this->createForm(AnonceType::class,$anonce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($anonce);
            $manager->flush();
            $this->addFlash(
                'success',"l'annonce <strong>{$anonce->getTitre() } </strong>a bien été enregistrée !</strong>"
            );
        }
        return $this->render('admin/ad/edit.html.twig',[
            'anonce'=>$anonce,
            'form'=>$form->createView()
        ]);
    }

    /**
 * @Route("/admin/comments/{id}/edit" ,name="admin_comments_edit")
 *
 * @param Comment $comment
 * @return Response
 */
public function editComment(Comment $comment ,Request $request,EntityManagerInterface $manager){
    $form=$this->createForm(AdminCommentType::class,$comment);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $manager->persist($comment);
        $manager->flush();
        $this->addFlash(
            'success',"Le commentaire N° <strong>{$comment->getId()}</strong> a bien été enregistrée !</strong>"
        );
    }
    return $this->render('admin/comment/edit.html.twig',[
        'comment'=>$comment,
        'form'=>$form->createView()
    ]);
}






}
