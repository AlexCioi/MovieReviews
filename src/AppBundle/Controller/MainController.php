<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function homepageAction(Request $request): Response
    {
        return $this->render('@App/Main/homepage.html.twig');
    }
}
