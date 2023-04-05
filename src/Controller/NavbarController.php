<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    public function __invoke(string $mainRequestPath, MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('_navbar.html.twig', [
            'movies' => $movies,
            'main_request_path' => $mainRequestPath,
        ]);
    }
}
