<?php

namespace MovieBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use MovieBundle\Entity\Movie;

class MovieManager
{
    public function __construct(
        protected EntityManagerInterface $em,
    )
    {
    }

    public function newInstance(): Movie
    {
        return new Movie();
    }
}
