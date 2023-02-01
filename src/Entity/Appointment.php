<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $patient_id;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $practitioner_id;

    #[ORM\ManyToOne]
    private ?Drug $drug_id = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consultation $consultation_id = null;

    public function __construct()
    {
        $this->practitioner_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPatientId(): int
    {
        return $this->patient_id;
    }

    public function setPatientId(int $patient_id): self
    {
        $this->patient_id = $patient_id;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPractitionerId(): Collection
    {
        return $this->practitioner_id;
    }

    public function addPractitionerId(User $practitionerId): self
    {
        if (!$this->practitioner_id->contains($practitionerId)) {
            $this->practitioner_id->add($practitionerId);
        }

        return $this;
    }

    public function removePractitionerId(User $practitionerId): self
    {
        $this->practitioner_id->removeElement($practitionerId);

        return $this;
    }

    public function getDrugId(): ?Drug
    {
        return $this->drug_id;
    }

    public function setDrugId(?Drug $drug_id): self
    {
        $this->drug_id = $drug_id;

        return $this;
    }

    public function getConsultationId(): ?Consultation
    {
        return $this->consultation_id;
    }

    public function setConsultationId(?Consultation $consultation_id): self
    {
        $this->consultation_id = $consultation_id;

        return $this;
    }
}
