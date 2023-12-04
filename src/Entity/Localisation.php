<?php

namespace App\Entity;

use App\Repository\LocalisationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nameLocalisation = null;

    #[ORM\Column(length: 50)]
    private ?string $nameStreet = null;

    #[ORM\Column]
    private ?int $numStreet = null;

    #[ORM\Column(length: 50)]
    private ?string $town = null;

    #[ORM\Column]
    private ?int $postalCode = null;

    #[ORM\Column]
    private ?float $lat = null;

    #[ORM\Column]
    private ?float $long = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameLocalisation(): ?string
    {
        return $this->nameLocalisation;
    }

    public function setNameLocalisation(string $nameLocalisation): static
    {
        $this->nameLocalisation = $nameLocalisation;

        return $this;
    }

    public function getNameStreet(): ?string
    {
        return $this->nameStreet;
    }

    public function setNameStreet(string $nameStreet): static
    {
        $this->nameStreet = $nameStreet;

        return $this;
    }

    public function getNumStreet(): ?int
    {
        return $this->numStreet;
    }

    public function setNumStreet(int $numStreet): static
    {
        $this->numStreet = $numStreet;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): static
    {
        $this->town = $town;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLong(): ?float
    {
        return $this->long;
    }

    public function setLong(float $long): static
    {
        $this->long = $long;

        return $this;
    }
}
