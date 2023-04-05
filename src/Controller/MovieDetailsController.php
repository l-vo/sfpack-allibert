<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieDetailsController extends AbstractController
{
    public const MOVIES = [
        [
            'title' => 'Super Mario Bros, le film',
            'releasedAt' => '2023-04-05',
            'genres' => ['action', 'adventure'],
            'image' => 'mario.jpg',
        ],
        [
            'title' => 'Mon chat et moi, la grande aventure de Rroû',
            'releasedAt' => '2023-04-05',
            'genres' => ['family', 'adventure'],
            'image' => 'chat.jpg',
        ],
        [
            'title' => 'Miracles',
            'releasedAt' => '2023-04-10',
            'genres' => ['documentary'],
            'image' => 'miracles.webp',
        ],
        [
            'title' => 'Les Ames soeurs',
            'releasedAt' => '2023-04-12',
            'genres' => ['drama'],
            'image' => 'ames.jpg',
        ],
    ];

    #[Route('/movies/{id<\d+>}/details', name: 'app_movie_details', methods: ['GET'])]
    public function __invoke(int $id): Response
    {
        $movie = self::MOVIES[$id - 1] ?? null;
        if ($movie === null) {
            throw $this->createNotFoundException(sprintf('Movie %d not found', $id));
        }

        return $this->render('movie_details/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}
