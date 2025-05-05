<?php

namespace MovieBundle\Controller;

use AppBundle\Service\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use MovieBundle\Entity\Movie;
use MovieBundle\Entity\UserMovieFavourite;
use MovieBundle\Service\UserMovieFavouriteManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserMovieFavouriteController extends AbstractController
{
    public function __construct(
        protected EntityService $entityService,
        protected EntityManagerInterface $em,
        protected UserMovieFavouriteManager $userMovieFavouriteManager,
    )
    {
    }

    #[IsGranted('ROLE_USER')]
    public function hitAction($movieId, Request $request): Response
    {
        $movie = $this->entityService->findOrReject(Movie::class, $movieId);

        $userMovieFavourite = $this->em->getRepository(UserMovieFavourite::class)->findOneBy(['user' => $this->getUser(), 'movie' => $movie]);

        if (!$userMovieFavourite) {
            $userMovieFavourite = $this->userMovieFavouriteManager->newInstance($this->getUser(), $movie);

            $this->entityService->save($userMovieFavourite);
        } else {
            $this->entityService->delete($userMovieFavourite);
        }

        return $this->redirect($request->headers->get('referer'));
    }
}
