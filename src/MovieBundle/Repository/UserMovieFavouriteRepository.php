<?php

namespace MovieBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MovieBundle\Entity\UserMovieFavourite;

class UserMovieFavouriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserMovieFavourite::class); // Make sure this is correct
    }
}
