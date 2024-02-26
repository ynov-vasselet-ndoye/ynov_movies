<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "get_movie",
 *          parameters = { "uid" = "expr(object.getUid())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="movie")
 * )
 *
 */
#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => 'movie:read']
        ),
        new Patch(inputFormats: ['json' => ['application/merge-patch+json']]),
    ],
    formats: ['jsonld', 'json', 'html', 'jsonhal', 'csv' => ['text/csv']]
)]
class Movie
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    #[Groups(["movie"])]
    private ?string $uid = null;

    #[ORM\Column(length: 128)]
    #[Groups(["movie", "movie:read"])]
    private ?string $nom = null;

    #[ORM\Column(type: "text", length: 4095)]
    #[Groups(["movie"])]
    private ?string $description = null;

    #[ORM\Column(type: "datetime")]
    #[Groups(["movie"])]
    private ?\DateTimeInterface $dateDeParution = null;

    #[ORM\Column(type: "integer", nullable: true)]
    #[Groups(["movie"])]
    private ?int $rate = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(["movie"])]
    private ?string $image = null;

//     #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'movies')]
//     #[Groups(["movie"])]
//     private Collection $category;

    public function __construct()
    {
//         $this->category = new ArrayCollection();
    }

    public function getUid(): ?string
    {
        return $this->uid;
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

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

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
}