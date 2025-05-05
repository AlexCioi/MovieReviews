<?php

namespace MovieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use MovieBundle\Repository\MovieCategoryRepository;

#[ORM\Entity(repositoryClass: MovieCategoryRepository::class)]
#[ORM\Table(name: 'movie__movie_category')]
class MovieCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    protected ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'categories')]
    protected ?Collection $movies = null;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): MovieCategory
    {
        $this->name = $name;

        return $this;
    }

    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): void
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
        }
    }

    public function removeMovie(Movie $movie): void
    {
        $this->movies->removeElement($movie);
    }
}
