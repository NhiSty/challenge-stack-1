<?php

namespace App\Entity;

use App\Repository\AgendaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgendaRepository::class)]
class Agenda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'agenda', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $availabilityDays = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $slots = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getAvailabilityDays(): array
    {
        return $this->availabilityDays;
    }

    public function setAvailabilityDays(?array $availabilityDays): self
    {
        $this->availabilityDays = $availabilityDays;

        return $this;
    }

    public function getSlots(): array
    {
        return $this->slots;
    }

    public function setSlots(?array $slots): self
    {
        $this->slots = $slots;

        return $this;
    }
}
