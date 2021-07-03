<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legend;

    /**
     * @ORM\ManyToOne(targetEntity=Anonce::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $anonce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getLegend(): ?string
    {
        return $this->legend;
    }

    public function setLegend(string $legend): self
    {
        $this->legend = $legend;

        return $this;
    }

    public function getAnonce(): ?Anonce
    {
        return $this->anonce;
    }

    public function setAnonce(?Anonce $anonce): self
    {
        $this->anonce = $anonce;

        return $this;
    }
}
