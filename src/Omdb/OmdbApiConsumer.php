<?php

namespace App\Omdb;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class OmdbApiConsumer
{
    public function __construct(private HttpClientInterface $omdbApi)
    {
    }

    public function findMovie(string $id): ?array
    {
        $response = $this->omdbApi->request('GET', '/', [
            'query' => [
                'i' => $id,
            ],
        ]);

        $data = $response->toArray();

        return isset($data['imdbID']) ? $data : null;
    }

    public function searchMovie(string $search): ?array
    {
        $response = $this->omdbApi->request('GET', '/', [
            'query' => [
                's' => $search,
            ],
        ]);

        $data = $response->toArray();

        return isset($data['Search']) ? $data['Search'] : null;
    }
}