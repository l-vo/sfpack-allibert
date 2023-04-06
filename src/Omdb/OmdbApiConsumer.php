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
                'i' => $id
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            return $response->toArray();
        }

        return null;
    }
}