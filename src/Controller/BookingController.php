<?php

namespace App\Controller;

use App\Entity\Anonce;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/anonce/{adresse}/booking", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Anonce $anonce,Request $request,EntityManagerInterface $manager)
    {

        $booking=new Booking();
        
        $form=$this->createForm(BookingType::class,$booking);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $user=$this->getUser();
            //$booking->prePersist();
            $booking->setBooker($user)
                    ->setAd($anonce);
            if(!$booking->isBookable()){
                $this->addFlash('warning',"Les dates que vous avez choisi ne peuvent être réservées :elles sont déja prises.");
            }
            else{    
            $manager->persist($booking);
            $manager->flush();
            return $this->redirectToRoute("booking_show",  ['id'=>$booking->getId(),'withAlert'=>true]);
            }
        }
        return $this->render("booking/book.html.twig", [
            'anonce' => $anonce,
            'form'=>$form->createView()
        ]);
    }

/**
 * @Route("/booking/{id}", name="booking_show")
 * @param Booking $booking
 * @return Response
 */
public function show(Booking $booking,Request $request,EntityManagerInterface $manager){
    $comment=new Comment();
    $form=$this->createForm(CommentType::class,$comment);
    $form->handleRequest($request);
   if($form->isSubmitted() && $form->isValid()){
        $comment->setAnonce($booking->getAd())
                ->setAuteur($this->getUser());
                $manager->persist($comment);
                $manager->flush();
                $this->addFlash('success',"Votre commentaire a bien été pris en compte !");
   }
   
    return $this->render('booking/show.html.twig',[
'booking'=>$booking,
'form'=>$form->createView()
]);
}

}
