<?php

namespace MovieBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use MovieBundle\Entity\Movie;
use MovieBundle\Entity\UserMovieFavourite;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\User;

class UserMovieFavouriteManager
{
    public function __construct(
        protected Security $security,
        protected EntityManagerInterface $em,
    )
    {
    }

    public function newInstance(User|UserInterface $user, Movie $movie): UserMovieFavourite
    {
        $userMovieFavourite = new UserMovieFavourite();

        $userMovieFavourite
            ->setUser($user)
            ->setMovie($movie);

        return $userMovieFavourite;
    }

    public function isMovieFavourite(Movie $movie): bool
    {
        $userMovieFavourite = $this->em->getRepository(UserMovieFavourite::class)->findOneBy(['user' => $this->security->getUser(), 'movie' => $movie]);

        return (bool)$userMovieFavourite;
    }
}
