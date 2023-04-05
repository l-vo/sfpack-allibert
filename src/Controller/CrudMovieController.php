<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/crud/movie')]
class CrudMovieController extends AbstractController
{
    #[Route('/', name: 'app_crud_movie_index', methods: ['GET'])]
    public function index(MovieRepository $movieRepository): Response
    {
        return $this->render('crud_movie/index.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_crud_movie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MovieRepository $movieRepository): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieRepository->save($movie, true);

            return $this->redirectToRoute('app_crud_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud_movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_movie_show', methods: ['GET'])]
    public function show(Movie $movie): Response
    {
        return $this->render('crud_movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crud_movie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Movie $movie, MovieRepository $movieRepository): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieRepository->save($movie, true);

            return $this->redirectToRoute('app_crud_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud_movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_movie_delete', methods: ['POST'])]
    public function delete(Request $request, Movie $movie, MovieRepository $movieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->request->get('_token'))) {
            $movieRepository->remove($movie, true);
        }

        return $this->redirectToRoute('app_crud_movie_index', [], Response::HTTP_SEE_OTHER);
    }
}