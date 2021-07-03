<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;

use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings/{page<\d+>?1}", name="admin_bookings_index")
     */
    public function index(PaginationService $pagination,$page)
    {
        $pagination->setEntityClass(Booking::class)
                    ->setPage($page);
        return $this->render('admin/booking/index.html.twig', [
            'pagination' =>$pagination
        ]);
    }

       /**
 * @Route("/admin/bookings/{id}/edit" ,name="admin_bookings_edit")
 *
 * @param Booking $booking
 * @return Response
 */
public function editBooking(Booking $booking ,Request $request,EntityManagerInterface $manager){
    $form=$this->createForm(AdminBookingType::class,$booking);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $booking->setAmount(0);
        $manager->persist($booking);
        $manager->flush();
        $this->addFlash(
            'success',"La Réservation N° <strong>{$booking->getId()}</strong> a bien été Modifiée !</strong>"
        );
        
    }
    return $this->render('admin/booking/edit.html.twig',[
        'booking'=>$booking,
        'form'=>$form->createView()
    ]);
}

/**
     * @Route("/admin/bookings/{id}/delete",name="admin_bookings_delete")
     *
     * @param Booking $booking
     * @param EntityManagerInterface $manager
     * @return Response
     */

public function delete(Booking $booking,EntityManagerInterface $manager){
    $manager->remove($booking);
    $manager->flush();
    $this->addFlash('success',"La réservation <strong>{$booking->getId()}</strong> a bien été supprimée !");
    return $this->redirectToRoute('admin_bookings_index');
}
}
