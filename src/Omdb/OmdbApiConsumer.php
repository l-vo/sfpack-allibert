<?php

namespace App\Omdb;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class OmdbApiConsumer
{
    public function __construct(private HttpClientInterface $httpClient, private string $apiKey)
    {
    }

    public function findMovie(string $id): ?array
    {
        $response = $this->httpClient->request('GET', 'http://www.omdbapi.com/', [
            'query' => [
                'apiKey' => $this->apiKey,
                'i' => $id
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            return $response->toArray();
        }

        return null;
    }
}