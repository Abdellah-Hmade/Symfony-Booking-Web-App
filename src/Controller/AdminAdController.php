<?php

namespace App\Controller;

use App\Entity\Anonce;
use App\Repository\AnonceRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads/{page<\d+>?1}", name="admin_ads_index")
     */
    public function index($page,PaginationService $pagination)
    {
        $pagination->setEntityClass(Anonce::class)
                    ->setPage($page);
        return $this->render('admin/ad/index.html.twig', [
            'pagination'=>$pagination
        ]);
    }

    /**
     * @Route("/admin/ads/{id}/delete",name="admin_ads_delete")
     *
     * @param Anonce $anonce
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Anonce $anonce,EntityManagerInterface $manager){
        if(count($anonce->getBookings()>0)){
            $this->addFlash('error',"Vous nous pouvez pas supprimer l'annonce <strong>{$anonce->getTitre()}</strong> Car il posséde des réservations déja!");
        }
        $manager->remove($anonce);
        $manager->flush();
        $this->addFlash('success',"L'annonce <strong>{$anonce->getTitre()}</strong> a bien été supprimée !");
        return $this->redirectToRoute('admin_ads_index');
    }
}
