<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity=Anonce::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ad;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention la date d'arrivée doit étre au bon format !")
     * @Assert\GreaterThan("today",message="la date d'arrivée doit étre ultérieure à la date d'aujourd'hui !",groups={"front"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention la date de départ doit étre au bon format !")
     * @Assert\GreaterThan("today",message="la date de départ doit étre au bon format !")
     * @Assert\GreaterThan(propertyPath="startDate",message="La date de départ doit étre différent de la date d'arrivée")
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;
    /**
     * 
     * @ORM\PreUpdate
     * @ORM\PrePersist
     *
     * @return void
     */
    public function prePersist(){
       if($this->createdAt==null){
            $this->createdAt=new \DateTime();
       }
       if($this->amount==null){
            $this->amount=$this->ad->getPrix() * $this->getDuration();
       } 
    }

    public function getDuration():?int{
        $diff=$this->endDate->diff($this->startDate);
        return $diff->days;
    }

    public function isBookable(){

        $notAvailableDays=$this->ad->getNotAvailableDays();
        $bookingDays=$this->getDays();
        $days=array_map(function($day){
            return $day->format('Y-m-d');
        },$bookingDays);
        $notAvailable=array_map(function($day){
            return $day->format('Y-m-d');
        },$notAvailableDays);
        foreach ($days as $day) {
            # code...
            if(array_search($day,$notAvailable)!==false){
                return false;
            }
            
        }
        return true;
    }

    public function getDays(){
        $resultat=range($this->startDate->getTimestamp(),$this->endDate->getTimestamp(),24*60*60);
        $days=array_map(function ($dayTimestamp){
            return new \DateTime(date('Y-m-d',$dayTimestamp));
        },$resultat);
        return $days;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getAd(): ?Anonce
    {
        return $this->ad;
    }

    public function setAd(?Anonce $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
