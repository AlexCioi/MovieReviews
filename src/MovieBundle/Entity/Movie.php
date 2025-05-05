<?php

namespace MovieBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use MovieBundle\Repository\MovieRepository;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\Table(name: 'movie__movie')]
class Movie
{
    const ENTITY_ALIAS = 'mv';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 128, nullable: false)]
    protected ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $description = null;

    #[ORM\ManyToMany(targetEntity: MovieCategory::class)]
    #[ORM\JoinTable(name: 'movie__movies_categories')]
    protected ?Collection $categories = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Movie
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Movie
    {
        $this->description = $description;

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(MovieCategory $category): void
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addMovie($this); // Sync the owning side
        }
    }

    public function removeCategory(MovieCategory $category): void
    {
        if ($this->categories->removeElement($category)) {
            $category->removeMovie($this); // Sync the owning side
        }
    }
}
