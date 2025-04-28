<?php

namespace MovieBundle\Controller;

use AppBundle\Service\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use MovieBundle\Entity\Movie;
use MovieBundle\Form\Factory\MovieFormFactory;
use MovieBundle\Service\MovieManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MovieController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected MovieManager $movieManager,
        protected MovieFormFactory $formFactory,
        protected EntityService $entityService,
    )
    {
    }

    public function listAction(Request $request): Response
    {
        $movies = $this->em->getRepository(Movie::class)->findAll();

        return $this->render('@Movie/Movie/public/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function listAdminAction(Request $request): Response
    {
        $movies = $this->em->getRepository(Movie::class)->findAll();

        return $this->render('@Movie/Movie/admin/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function newAdminAction(Request $request): Response
    {
        $movie = $this->movieManager->newInstance();

        $form = $this->formFactory->getCreateForm($movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($movie);

            return $this->redirectToRoute('admin_movie_movie_list');
        }

        return $this->render('@Movie/Movie/admin/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function editAdminAction($id, Request $request): Response
    {
        $movie = $this->entityService->findOrReject(Movie::class, $id);

        $form = $this->formFactory->getEditForm($movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($movie);

            return $this->redirectToRoute('admin_movie_movie_list');
        }

        return $this->render('@Movie/Movie/admin/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function deleteAdminAction($id, Request $request): Response
    {
        $movie = $this->entityService->findOrReject(Movie::class, $id);

        $this->entityService->delete($movie);

        return $this->redirect($request->headers->get('referer'));
    }
}
