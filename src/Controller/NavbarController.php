<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('_navbar.html.twig', ['movies' => MovieDetailsController::MOVIES]);
    }
}
