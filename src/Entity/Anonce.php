<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnonceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AnonceRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"titre"},
 *  message="Une autre Annonce possède le mème titre veuillez le modifier."   
 * )
 *
 *
 * 
 */
class Anonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10,max=255,minMessage="Le titre doit faire plus de 10 caractères",maxMessage="Max Longeur du titre est 255 caractères")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $adresse;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="text")
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="integer")
     */
    private $chambres;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="anonce", orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="anonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="ad")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="anonce", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeAdresse(){
        if(empty($this->adresse)){
            $slugify=new Slugify();
            $this->adresse=$slugify->slugify($this->titre);
        }

    }
/**
 * Undocumented function
 * 
 * @return array
 */
    public function getNotAvailableDays(){
        $notAvailableDays=[];
        foreach ($this->bookings as $booking) {
            # code...
            $resultat=range($booking->getStartDate()->getTimestamp(),$booking->getEndDate()->getTimestamp(),24*60*60);
            $days=array_map(function ($dayTimestamp){
                return new \DateTime(date('Y-m-d',$dayTimestamp));
            },$resultat);
            $notAvailableDays=array_merge($notAvailableDays,$days);
        }
        return $notAvailableDays;
    }
/**
 * 
 * 
 *
 * @return integer
 */
public function getAvgRatings(){
$comment=new Comment();
$sum=0;
$i=0;
    foreach($this->comments as $comment){
        $sum=$sum+$comment->getRating();
        $i++;
    }
    if($i>0){
return ($sum/$i);
    }
    else{
        return 0;
    }
}

/**
 * Undocumented function
 *@param User $author
 * @return Comment
 */

 public function getCommentFromAuthor(User $author){

    foreach ($this->comments as $comment){
        if($comment->getAuteur()===$author){
            return $comment;
        }
    
    }
return null; 
}
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getChambres(): ?int
    {
        return $this->chambres;
    }

    public function setChambres(int $chambres): self
    {
        $this->chambres = $chambres;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAnonce($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getAnonce() === $this) {
                $image->setAnonce(null);
            }
        }

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setAd($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getAd() === $this) {
                $booking->setAd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAnonce($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAnonce() === $this) {
                $comment->setAnonce(null);
            }
        }

        return $this;
    }

}
