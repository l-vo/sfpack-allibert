<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Event\MoviePageViewedEvent;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class MovieDetailsController extends AbstractController
{
    #[Route('/movies/{id<\d+>}/details', name: 'app_movie_details', methods: ['GET'])]
    public function __invoke(int $id, MovieRepository $movieRepository, EventDispatcherInterface $eventDispatcher): Response
    {
        $movie = $movieRepository->find($id);
        if ($movie === null) {
            throw $this->createNotFoundException(sprintf('Movie %d not found', $id));
        }

        $eventDispatcher->dispatch(new MoviePageViewedEvent($movie));

        return $this->render('movie_details/index.html.twig', [
            'movie' => $movie,
        ]);
    }

    // Or with param converters https://symfony.com/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html
    /*#[Route('/movies/{id<\d+>}/details', name: 'app_movie_details', methods: ['GET'])]
    public function __invoke(Movie $movie): Response
    {
        return $this->render('movie_details/index.html.twig', [
            'movie' => $movie,
        ]);
    }*/
}
