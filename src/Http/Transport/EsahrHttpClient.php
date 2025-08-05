<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Transport;

use Helip\SielEsahrClient\Dto\Common\ErrorResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiException;
use RuntimeException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class EsahrHttpClient implements EsahrHttpClientInterface
{
    private readonly string $baseUrl;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        string $apiBaseUrl
    ) {
        $this->baseUrl = rtrim($apiBaseUrl, '/');
    }

    public function get(string $path, string $accessToken, array $query = []): array
    {
        return $this->request('GET', $path, $accessToken, ['query' => array_filter($query)]);
    }

    public function post(string $path, string $accessToken, array $json = []): array
    {
        return $this->request('POST', $path, $accessToken, ['json' => $json]);
    }

    public function put(string $path, string $accessToken, array $json = []): array
    {
        return $this->request('PUT', $path, $accessToken, ['json' => $json]);
    }

    private function request(string $method, string $path, string $accessToken, array $options): array
    {
        $url = $this->baseUrl . '/' . ltrim($path, '/');

        $options['headers']['Authorization'] = 'Bearer ' . $accessToken;
        $options['headers']['Accept'] = 'application/json';

        try {
            $response = $this->httpClient->request($method, $url, $options);
            $status = $response->getStatusCode();

            // Catche les erreurs 4xx et 5xx et renvoie une exception EsahrApiException
            if ($status >= 400) {
                $body = $response->getContent(false); // Pas d'exception levée
                $data = json_decode($body, true);

                if (is_array($data) && isset($data['type'], $data['title'])) {
                    // Erreur métier ESAHR détectée
                    throw new EsahrApiException(ErrorResponseDto::fromArray($data));
                }

                // Sinon, réponse invalide ou serveur HS → erreur technique
                throw new RuntimeException(sprintf('ESAHR API returned error %d with non-standard body: %s', $status, $body));
            }

            return $response->toArray();
        } catch (TransportExceptionInterface | ClientExceptionInterface | ServerExceptionInterface $e) {
            throw new RuntimeException(sprintf('ESAHR API %s %s transport error: %s', $method, $url, $e->getMessage()), 0, $e);
        }
    }
}
