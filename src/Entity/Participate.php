<?php

namespace App\Entity;

use App\Repository\ParticipateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParticipateRepository::class)]
class Participate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $rdv_date = null;

    #[ORM\Column]
    private ?bool $confirm = null;

    #[ORM\ManyToOne]
    private ?User $userId = null;

    #[ORM\ManyToOne]
    private ?Add $addId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRdvDate(): ?\DateTimeInterface
    {
        return $this->rdv_date;
    }

    public function setRdvDate(\DateTimeInterface $rdv_date): static
    {
        $this->rdv_date = $rdv_date;

        return $this;
    }

    public function isConfirm(): ?bool
    {
        return $this->confirm;
    }

    public function setConfirm(bool $confirm): static
    {
        $this->confirm = $confirm;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getAddId(): ?Add
    {
        return $this->addId;
    }

    public function setAddId(?Add $addId): static
    {
        $this->addId = $addId;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
