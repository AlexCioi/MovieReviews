<?php

namespace MovieBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use MovieBundle\Repository\UserMovieFavouriteRepository;
use UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: UserMovieFavouriteRepository::class)]
#[ORM\Table(name: 'movie__user_movie_favourite')]
class UserMovieFavourite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    protected ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Movie::class)]
    #[ORM\JoinColumn(name: 'movie_id', referencedColumnName: 'id', nullable: false)]
    protected ?Movie $movie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): UserMovieFavourite
    {
        $this->user = $user;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): UserMovieFavourite
    {
        $this->movie = $movie;

        return $this;
    }
}
