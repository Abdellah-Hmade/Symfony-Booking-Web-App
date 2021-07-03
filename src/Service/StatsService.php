<?php

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;

class StatsService {
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager=$manager;
    }

    public function getUsersCount(){
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }
    public function getAdsCount(){
        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Anonce a')->getSingleScalarResult();
    }
    
    public function getBookingsCount(){
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking b')->getSingleScalarResult();
    }
    public function getCommentsCount(){
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();
    }


    public function getAdStats($direction){
        return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note , a.titre ,a.id ,a.coverImage ,u.prenom ,u.nom ,u.avatar FROM APP\Entity\Comment c 
            JOIN c.anonce a
            JOIN a.auteur u
            GROUP BY a 
            ORDER BY note '.$direction)->setMaxResults(5)->getResult();
    }


    public function getStats(){
        $users=$this->getUsersCount();
        $anonces=$users=$this->getAdsCount();
        $bookings=$users=$this->getBookingsCount();
        $comments=$users=$this->getCommentsCount();
        return compact('users','anonces','bookings','comments');
    }    
}

?>