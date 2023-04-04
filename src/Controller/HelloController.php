<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{name<\w+>}', name: 'app_hello', methods: ['GET'])]
    public function index(?string $name = null): Response
    {
        return $this->render('hello/index.html.twig', [
            'name' => $name,
        ]);
    }
}
