<?php

namespace App\Controller;

use App\Repository\AnonceRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

 /**
 * @Route("/",name="homepage")
 */


    public function home(AnonceRepository $anonces,UserRepository $users){
        
        return $this->render('home.html.twig',
    [
        'users'=>$users->findBestUsers(2),
        'anonces'=>$anonces->findBestAds(3)
    ]
    );
    }

}


?>