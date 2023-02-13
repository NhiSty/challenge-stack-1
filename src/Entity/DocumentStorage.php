<?php

namespace App\Entity;

use App\Repository\DocumentStorageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: DocumentStorageRepository::class)]
#[Vich\Uploadable]

class DocumentStorage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $description = '';

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[Vich\UploadableField(mapping: 'documents', fileNameProperty: 'name')]
    #[Assert\NotBlank(message : "Vous devez sélectionner un fichier")]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['application/pdf', 'image/png', 'image/jpeg'],
        maxSizeMessage: 'Votre fichier fait {{ size }} et ne doit pas dépasser {{ limit }}',
        mimeTypesMessage: 'Fichier accepté : pdf / png / jpeg',
        uploadErrorMessage: 'Une erreur est survenue lors de l\'envoi du fichier'
    )]
    private $docFile = [];


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDocFile(): ?array
    {
        return $this->docFile;
    }


    /**
     * @param string|null $name
     * @return DocumentStorage
     */

    public function setName(string $name): DocumentStorage
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }


    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @param File|null $docFile
     * @return DocumentStorage
     */
    public function setDocFile(array $docFile): self
    {
        $this->docFile = $docFile;
        return $this;
    }

}
