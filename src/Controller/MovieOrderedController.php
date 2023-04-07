<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MovieOrderedController extends AbstractController
{
    #[Route('/movie/{id<\d+>}/ordered', name: 'app_movie_ordered')]
    #[IsGranted('ORDER_MOVIE', 'movie')]
    public function index(Movie $movie): Response
    {
        return $this->render('movie_ordered/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}
