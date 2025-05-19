<?php

namespace MovieBundle\Controller;

use AppBundle\Service\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use MovieBundle\Entity\MovieCategory;
use MovieBundle\Form\Factory\MovieCategoryFormFactory;
use MovieBundle\Service\MovieCategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MovieCategoryController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected MovieCategoryFormFactory $formFactory,
        protected MovieCategoryManager $movieCategoryManager,
        protected EntityService $entityService,
    )
    {
    }

    public function listAction(): Response
    {

    }

    #[IsGranted('ROLE_ADMIN')]
    public function listAdminAction(): Response
    {
        $movieCategories = $this->em->getRepository(MovieCategory::class)->findAll();

        return $this->render('@Movie/MovieCategory/admin/list.html.twig', [
            'movieCategories' => $movieCategories
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function newAdminAction(Request $request): Response
    {
        $movieCategory = $this->movieCategoryManager->newInstance();

        $form = $this->formFactory->getCreateForm($movieCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($movieCategory);

            return $this->redirectToRoute('admin_movie_movie_category_list');
        }

        return $this->render('@Movie/MovieCategory/admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function editAdminAction($id, Request $request): Response
    {
        $movieCategory = $this->entityService->findOrReject(MovieCategory::class, $id);

        $form = $this->formFactory->getEditForm($movieCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($movieCategory);

            return $this->redirectToRoute('admin_movie_movie_category_list');
        }

        return $this->render('@Movie/MovieCategory/admin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
