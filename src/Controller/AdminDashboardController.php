<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\StatsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard_index")
     */
    public function index(EntityManagerInterface $manager,StatsService $stats)
    {
        
        return $this->render('admin/dashboard/index.html.twig', [
            'stats' =>$stats->getStats(),
            'bestads'=>$stats->getAdStats('DESC')
            ,'worstads'=>$stats->getAdStats('ASC')
        ]);
    }
}
