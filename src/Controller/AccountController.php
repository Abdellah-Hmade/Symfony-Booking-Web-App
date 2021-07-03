<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpadte;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();
        $username=$utils->getLastUsername();
        
        return $this->render('account/login.html.twig',[
            'hasError'=>$error !==null,
            'username'=>$username
        ]);
    }
/**
 * 
 * @Route("/logout",name="account_logout")
 * @return Response
 */
public function logout(){


}
/**
 * 
 * @Route("/register",name="account_register")
 * 
 * @return Response
 */
public function register(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder){
$user=new User();
$form=$this->createForm(RegistrationType::class,$user);
$form->handleRequest($request);
     
    
    if($form->isSubmitted()&&$form->isValid()){
        $hash=$encoder->encodePassword($user,$user->getHash());
        $user->setHash($hash);
        $manager->persist($user);
        $manager->flush();
       $this->addFlash('success',"Votre Compte <strong>".$user->getEmail()."</strong> a été bien créé!");
        return $this->redirectToRoute('account_login');
    }    


return $this->render('account/registration.html.twig',[
    'form'=>$form->createView()
]);
}
/**
 * @Route("/account/profile",name="account_profile")
 * @IsGranted("ROLE_USER")
 * @return Response
 */

public function profile(Request $request,EntityManagerInterface $manager){
    $user=$this->getUser();
    $form=$this->createForm(AccountType::class,$user);
    $form->handleRequest($request);
    if($form->isSubmitted()&&$form->isValid()){
        $manager->persist($user);
        $manager->flush();
       $this->addFlash('success',"Les informations de Votre Compte <strong>".$user->getEmail()."</strong> a été bien Modifier!");
        return $this->redirectToRoute('homepage');
    }    
    return$this->render('account/profile.html.twig',[
        'form'=>$form->createView()
    ]);
}


/**
 * @Route("/account/update_password",name="account_up_password")
 * @IsGranted("ROLE_USER")
 * @return Response
 */

public function updatePassword(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder){
    $passwordUpdate=new PasswordUpadte();
    $user=$this->getUser();
    $form=$this->createForm(PasswordUpdateType::class,$passwordUpdate);
    $form->handleRequest($request);
    if($form->isSubmitted()&&$form->isValid()){
        if(!password_verify($passwordUpdate->getOldPassword(),$user->getHash())){
            $form->get("oldPassword")->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            return $this->redirectToRoute('homepage');
        }else{
            $hash=$encoder->encodePassword($user,$passwordUpdate->getNewPassword());
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success',"<strong>".$user->getPrenom()."</strong> : Le mot de passe de Votre Compte a été bien Modifier!");
        return $this->redirectToRoute('homepage');
        }
        
    }    
    return$this->render('account/password.html.twig',[
        'form'=>$form->createView()
    ]);
}
/**
 * @route("/account" ,name="account_index")
 * @IsGranted("ROLE_USER")
 * @return Response
 */

public function myAccount(){
    return$this->render('user/index.html.twig',[
        'user'=>$this->getUser()
    ]);
}
/**
 * 
 *@Route("/account/bookings",name="account_bookings")
 * @return void
 */
public function bookings(){
    return $this->render('account/bookings.html.twig');

}


}
