<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 1)]
    private ?string $gender = null;

    #[ORM\ManyToMany(targetEntity: Appointment::class, mappedBy: 'practitioner_id')]
    private Collection $appointments;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?DocumentStorage $documentStorage = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Clinic $clinic = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Speciality $speciality = null;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?Agenda $agenda = null;

    #[ORM\OneToOne(mappedBy: 'applicant', cascade: ['persist', 'remove'])]
    private ?Demand $demand = null;

    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->addPractitionerId($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            $appointment->removePractitionerId($this);
        }

        return $this;
    }

    public function getDocumentStorage(): ?DocumentStorage
    {
        return $this->documentStorage;
    }

    public function setDocumentStorage(DocumentStorage $documentStorage): self
    {
        // set the owning side of the relation if necessary
        if ($documentStorage->getUserId() !== $this) {
            $documentStorage->setUserId($this);
        }

        $this->documentStorage = $documentStorage;

        return $this;
    }

    public function getClinicId(): ?Clinic
    {
        return $this->clinic;
    }

    public function setClinicId(?Clinic $clinic): self
    {
        $this->clinic = $clinic;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    public function getAgenda(): ?Agenda
    {
        return $this->agenda;
    }

    public function setAgenda(Agenda $agenda): self
    {
        // set the owning side of the relation if necessary
        if ($agenda->getOwner() !== $this) {
            $agenda->setOwner($this);
        }

        $this->agenda = $agenda;

        return $this;
    }

    public function getDemand(): ?Demand
    {
        return $this->demand;
    }

    public function setDemand(Demand $demand): self
    {
        // set the owning side of the relation if necessary
        if ($demand->getApplicant() !== $this) {
            $demand->setApplicant($this);
        }

        $this->demand = $demand;

        return $this;
    }
}
