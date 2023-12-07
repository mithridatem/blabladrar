<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titleEvent = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descEvent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEvent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgEvent = null;

    #[ORM\ManyToOne]
    private ?Localisation $localisationId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleEvent(): ?string
    {
        return $this->titleEvent;
    }

    public function setTitleEvent(string $titleEvent): static
    {
        $this->titleEvent = $titleEvent;

        return $this;
    }

    public function getDescEvent(): ?string
    {
        return $this->descEvent;
    }

    public function setDescEvent(string $descEvent): static
    {
        $this->descEvent = $descEvent;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): static
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getImgEvent(): ?string
    {
        return $this->imgEvent;
    }

    public function setImgEvent(?string $imgEvent): static
    {
        $this->imgEvent = $imgEvent;

        return $this;
    }

    public function getLocalisationId(): ?Localisation
    {
        return $this->localisationId;
    }

    public function setLocalisationId(?Localisation $localisationId): static
    {
        $this->localisationId = $localisationId;

        return $this;
    }
}
