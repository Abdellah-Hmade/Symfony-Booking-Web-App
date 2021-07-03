<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
        /**
     * @Route("/admin/users/{page<\d+>?1}", name="admin_users_index")
     */
    public function index(PaginationService $pagination,$page)
    {
        $pagination->setEntityClass(User::class)
                    ->setPage($page);
        return $this->render('admin/user/index.html.twig', [
            'pagination' =>$pagination
        ]);
    }
       /**
 * @Route("/admin/users/{id}/edit" ,name="admin_users_edit")
 *
 * @param User $user
 * @return Response
 */
public function editUser(User $user ,Request $request,EntityManagerInterface $manager){
    $form=$this->createForm(AdminUserType::class,$user);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        
        $manager->persist($user);
        $manager->flush();
        $this->addFlash(
            'success',"les Informations du compte <strong>{$user->getTnom()}</strong> a bien été Modifiée !</strong>"
        );
        
    }
    return $this->render('admin/user/edit.html.twig',[
        'user'=>$user,
        'form'=>$form->createView()
    ]);
}

/**
     * @Route("/admin/users/{id}/delete",name="admin_users_delete")
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */

public function delete(User $user,EntityManagerInterface $manager){
    $manager->remove($user);
    $manager->flush();
    $this->addFlash('success',"Le compte de l'utilisateur <strong>{$user->getId()}</strong> a bien été supprimée !");
    return $this->redirectToRoute('admin_users_index');
}

/**
 * @Route ("/admin/users/{id}/profile",name="admin_users_profile")
 * @param User $user
 * 
 */
public function profile(User $user){

    return $this->render('admin/user/profile.html.twig', [
        'user' =>$user 
    ]);

}

}
