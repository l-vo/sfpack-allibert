<?php

namespace App\Controller;

use App\Omdb\OmdbApiConsumer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestApiController extends AbstractController
{
    #[Route('/test/api', name: 'app_test_api')]
    public function index(OmdbApiConsumer $omdbApiConsumer): Response
    {
        dump($omdbApiConsumer->findMovie('tt12176466'));

        return new Response('<body></body>');
    }
}
