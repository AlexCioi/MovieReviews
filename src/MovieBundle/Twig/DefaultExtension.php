<?php

namespace MovieBundle\Twig;

use MovieBundle\Entity\Movie;
use MovieBundle\Service\UserMovieFavouriteManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DefaultExtension extends AbstractExtension
{
    public function __construct(
        protected UserMovieFavouriteManager $userMovieFavouriteManager,
    )
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('isMovieFavourite', [$this, 'isMovieFavourite'])
        ];
    }

    public function isMovieFavourite(Movie $movie): bool
    {
        return $this->userMovieFavouriteManager->isMovieFavourite($movie);
    }
}
