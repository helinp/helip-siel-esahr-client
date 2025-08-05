<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Transport;

use RuntimeException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class NamHttpClient implements NamHttpClientInterface
{
    private readonly string $baseUrl;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        string $namBaseUrl // ex: https://secure-acc.etnic.be/nidp/oauth/nam/
    ) {
        $this->baseUrl = rtrim($namBaseUrl, '/');
    }

    public function post(string $path, string $accessToken, array $json = []): array
    {
        $url = $this->baseUrl . '/' . ltrim($path, '/');

        try {
            $response = $this->httpClient->request(
                'POST',
                $url,
                [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $json,
                ]
            );

            if (200 !== $response->getStatusCode()) {
                throw new RuntimeException(
                    sprintf(
                        'NAM API POST %s failed: %s',
                        $url,
                        $response->getStatusCode()
                    )
                );
            }

            return $response->toArray();
        } catch (TransportExceptionInterface | ClientExceptionInterface | ServerExceptionInterface $e) {
            throw new RuntimeException(sprintf('NAM API POST %s error: %s', $url, $e->getMessage()), 0, $e);
        }
    }

    public function get(string $path, string $accessToken, array $query = []): array
    {
        $url = $this->baseUrl . '/' . ltrim($path, '/');

        try {
            $response = $this->httpClient->request(
                'GET',
                $url,
                [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
                'query' => array_filter($query),
                ]
            );

            if (200 !== $response->getStatusCode()) {
                throw new RuntimeException(
                    sprintf(
                        'NAM API GET %s failed: %s',
                        $url,
                        $response->getStatusCode()
                    )
                );
            }

            return $response->toArray();
        } catch (TransportExceptionInterface | ClientExceptionInterface | ServerExceptionInterface $e) {
            throw new RuntimeException(sprintf('NAM API GET %s error: %s', $url, $e->getMessage()), 0, $e);
        }
    }
}
