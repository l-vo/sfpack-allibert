<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieDetailsController extends AbstractController
{
    #[Route('/movies/{id<\d+>}/details', name: 'app_movie_details', methods: ['GET'])]
    public function __invoke(int $id): Response
    {
        $movies = [
            [
                'title' => 'Super Mario Bros, le film',
                'releasedAt' => '2023-04-05',
                'genres' => ['action', 'adventure']
            ],
            [
                'title' => 'Mon chat et moi, la grande aventure de Rroû',
                'releasedAt' => '2023-04-05',
                'genres' => ['family', 'adventure'],
            ],
            [
                'title' => 'Miracles',
                'releasedAt' => '2023-04-10',
                'genres' => ['documentary'],
            ],
            [
                'title' => 'Les Ames soeurs',
                'releasedAt' => '2023-04-12',
                'genres' => ['drama'],
            ],
        ];

        $movie = $movies[$id - 1] ?? null;
        if ($movie === null) {
            throw $this->createNotFoundException(sprintf('Movie %d not found', $id));
        }

        return $this->render('movie_details/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}
