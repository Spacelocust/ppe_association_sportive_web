<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 * @Vich\Uploadable
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Assert\NotBlank(message="Veuillez saisir un titre", groups={"creation"})
     * @ORM\Column(type="string", length=256)
     */
    private string $nom;

    /**
     * @Assert\NotBlank(message="Veuillez saisir une description", groups={"creation"})
     * @ORM\Column(type="string", length=612)
     */
    private string $description;

    /**
     * @Assert\NotNull(groups={"creation"})
     * @ORM\Column(type="datetime")
     */
    private DateTime $debuterLe;

    /**
     * @Assert\NotNull(groups={"creation"})
     * @ORM\Column(type="datetime")
     */
    private DateTime $finirLe;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $creerLe;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $modifierLe;

    /**
     * @Assert\NotBlank(message="Veuillez saisir un nombre entier positif.", groups={"creation"})
     * @Assert\Regex(
     *     pattern = "/^\+?\d+$/",
     *     message = "Veuillez saisir un nombre entier positif.",
     *     groups={"creation"}
     * )
     * @ORM\Column(type="integer")
     */
    private ?int $nombrePlaces = null;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $actif;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private ?string $image = null;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private ?string $vignette = null;

    /**
     * @Vich\UploadableField(mapping="evenement_image", fileNameProperty="image")
     * @var File|null $imageFichier
     */
    private ?File $imageFichier = null;

    /**
     * @Vich\UploadableField(mapping="evenement_vignette", fileNameProperty="vignette")
     * @var File|null $vignetteFichier
     */
    private ?File $vignetteFichier = null;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="evenements")
     * @ORM\JoinColumn(name="sport", nullable=false, referencedColumnName="id")
     */
    private Sport $sport;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="evenements")
     * @ORM\JoinColumn(name="type", nullable=false, referencedColumnName="id")
     */
    private Type $type;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="evenement", orphanRemoval=true)
     */
    private Collection $inscriptions;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="evenements")
     * @ORM\JoinColumn(name="categorie", nullable=false, referencedColumnName="id")
     */
    private Categorie $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="evenement")
     */
    private Collection $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->debuterLe = new \DateTime();
        $this->finirLe = new \DateTime();
        $this->setCreerLe();
        $this->setModifierLe();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Evenement
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Evenement
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDebuterLe(): ?DateTime
    {
        return $this->debuterLe;
    }

    /**
     * @param DateTime $debuterLe
     * @return Evenement
     */
    public function setDebuterLe(DateTime $debuterLe): self
    {
        $this->debuterLe = $debuterLe;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getFinirLe(): DateTime
    {
        return $this->finirLe;
    }

    /**
     * @param DateTime $finirLe
     * @return Evenement
     */
    public function setFinirLe(DateTime $finirLe): self
    {
        $this->finirLe = $finirLe;

        return $this;
    }

    public function setCreerLe(): self
    {
        $this->creerLe = new DateTime();

        return $this;
    }

    public function getCreerLe(): DateTime
    {
        return $this->creerLe;
    }

    public function setModifierLe(): self
    {
        $this->modifierLe = new DateTime();

        return $this;
    }

    public function getModifierLe(): ?DateTime
    {
        return $this->modifierLe;
    }

    /**
     * @return int
     */
    public function getNombrePlaces(): int
    {
        return $this->nombrePlaces;
    }

    /**
     * @param int $nombrePlaces
     * @return Evenement
     */
    public function setNombrePlaces(?int $nombrePlaces = null): self
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVignette(): ?string
    {
        return $this->vignette;
    }

    public function setVignette(?string $vignette = null): self
    {
        $this->vignette = $vignette;

        return $this;
    }

    public function getImageFichier(): ?File
    {
        return $this->imageFichier;
    }

    public function setImageFichier(File $image): void
    {
        $this->imageFichier = $image;

        if ($image) {
            $this->setModifierLe();
        }
    }

    public function getVignetteFichier(): ?File
    {
        return $this->vignetteFichier;
    }

    public function setVignetteFichier(File $vignetteFichier): void
    {
        $this->vignetteFichier = $vignetteFichier;

        if ($vignetteFichier) {
            $this->setModifierLe();
        }
    }

    /**
     * @return Sport
     */
    public function getSport(): Sport
    {
        return $this->sport;
    }

    /**
     * @param Sport $sport
     * @return Evenement
     */
    public function setSport(Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscription(): ?Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscriptions): self
    {
        if (!$this->inscriptions->contains($inscriptions)) {
            $this->inscriptions[] = $inscriptions;
            $inscriptions->setEvenement($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscriptions): self
    {
        if ($this->inscriptions->contains($inscriptions)) {
            $this->inscriptions->remove($inscriptions);
            // set the owning side to null (unless already changed)
            if ($inscriptions->getEvenement() === $this) {
                $inscriptions->setEvenement(null);
            }
        }

        return $this;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocuments(Document $documents): self
    {
        if (!$this->documents->contains($documents)) {
            $this->documents[] = $documents;
            $documents->setEvenement($this);
        }

        return $this;
    }

    public function removeDocuments(Document $documents): self
    {
        if ($this->documents->removeElement($documents)) {
            // set the owning side to null (unless already changed)
            if ($documents->getEvenement() === $this) {
                $documents->setEvenement(null);
            }
        }

        return $this;
    }
}