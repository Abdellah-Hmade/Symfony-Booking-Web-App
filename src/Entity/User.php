<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Un autre utilisateur à déja cette adresse email, veuillez la modifier."
 * )
 *  
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez renseigner votre prènom .")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez renseigner votre Nom .")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez renseigner votre adresse email !")
     * @Assert\Email(message="Veuillez donner un email valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Veuillez donner une URL valide !")
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $hash;
    /**
     * @Assert\EqualTo(propertyPath="hash",message="vous n'avez pas corectement confirmer.")
     *
     * 
     */
    public $PasswordConfirm;
    

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10,minMessage="Votre Introduction doit faire au moins 10 caractères")
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=100,minMessage="Votre Introduction doit faire au moins 100 caractères")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Anonce::class, mappedBy="auteur")
     */
    private $anonces;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="booker")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="auteur", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->anonces = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
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
            $this->adresse=$slugify->slugify($this->prenom.' '.$this->nom);
        }

    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function getTnom(): ?string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection|Anonce[]
     */
    public function getAnonces(): Collection
    {
        return $this->anonces;
    }

    public function addAnonce(Anonce $anonce): self
    {
        if (!$this->anonces->contains($anonce)) {
            $this->anonces[] = $anonce;
            $anonce->setAuteur($this);
        }

        return $this;
    }

    public function removeAnonce(Anonce $anonce): self
    {
        if ($this->anonces->contains($anonce)) {
            $this->anonces->removeElement($anonce);
            // set the owning side to null (unless already changed)
            if ($anonce->getAuteur() === $this) {
                $anonce->setAuteur(null);
            }
        }

        return $this;
    }
    public function getRoles()
    {
        $roles=$this->userRoles->map(function($role){
            return $role->getTitle();
        })->toArray();
        $roles[]='ROLE_USER';
        return $roles;
    }

    public function getPassword()
    {
        return $this->hash;
    }
    public function getSalt(){}
    public function getUsername(){
        return $this->email;
    }
    public function eraseCredentials(){}

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

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
            $booking->setBooker($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getBooker() === $this) {
                $booking->setBooker(null);
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
            $comment->setAuteur($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuteur() === $this) {
                $comment->setAuteur(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->userRoles->title;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
