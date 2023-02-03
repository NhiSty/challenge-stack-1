<?php

namespace App\Entity;

use App\Repository\DemandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandRepository::class)]
class Demand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: NecessaryDocument::class, inversedBy: 'demands')]
    private Collection $necessaryDocuments;

    #[ORM\Column]
    private ?bool $state = null;

    #[ORM\OneToOne(inversedBy: 'demand', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $applicant = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $fileNames = [];

    public function __construct()
    {
        $this->necessaryDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, NecessaryDocument>
     */
    public function getNecessaryDocuments(): Collection
    {
        return $this->necessaryDocuments;
    }

    public function addNecessaryDocument(NecessaryDocument $necessaryDocument): self
    {
        if (!$this->necessaryDocuments->contains($necessaryDocument)) {
            $this->necessaryDocuments->add($necessaryDocument);
        }

        return $this;
    }

    public function removeNecessaryDocument(NecessaryDocument $necessaryDocument): self
    {
        $this->necessaryDocuments->removeElement($necessaryDocument);

        return $this;
    }

    public function isState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getApplicant(): ?User
    {
        return $this->applicant;
    }

    public function setApplicant(User $applicant): self
    {
        $this->applicant = $applicant;

        return $this;
    }

    public function getFileNames(): array
    {
        return $this->fileNames;
    }

    public function setFileNames(array $fileNames): self
    {
        $this->fileNames = $fileNames;

        return $this;
    }
}
