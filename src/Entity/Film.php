<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "get_film",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="film")
 * )
 *
 */
#[ORM\Entity(repositoryClass: FilmRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => 'film:read']
        ),
        new Patch(inputFormats: ['json' => ['application/merge-patch+json']]),
    ],
    formats: ['jsonld', 'json', 'html', 'jsonhal', 'csv' => ['text/csv']]
)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["film"])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(["film", "film:read"])]
    private ?string $nom = null;

    #[ORM\Column(type: "text", length: 2048)]
    #[Groups(["film"])]
    private ?string $description = null;

    #[ORM\Column(type: "datetime")]
    #[Groups(["film"])]
    private ?\DateTimeInterface $dateDeParution = null;

    #[ORM\Column(type: "integer", nullable: true)]
    #[Groups(["film"])]
    private ?int $note = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(["film"])]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'films')]
    #[Groups(["film"])]
    private Collection $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDeParution(): ?\DateTimeInterface
    {
        return $this->dateDeParution;
    }

    public function setDateDeParution(?\DateTimeInterface $dateDeParution): self
    {
        $this->dateDeParution = $dateDeParution;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }
}
