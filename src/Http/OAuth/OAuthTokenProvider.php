<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\OAuth;

use DateTimeImmutable;
use Helip\SielEsahrClient\Exception\AuthenticationException;
use Helip\SielEsahrClient\Dto\OAuth\Credentials;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class OAuthTokenProvider
{
    private ?string $accessToken = null;
    private ?DateTimeImmutable $expiresAt = null;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly Credentials $credentials
    ) {
    }

    /**
     * Retourne un token d’accès valide, ou en demande un nouveau si expiré.
     *
     * @throws AuthenticationException
     */
    public function getAccessToken(): string
    {
        if (
            $this->accessToken !== null
            && $this->expiresAt !== null
            && $this->expiresAt > new DateTimeImmutable()
        ) {
            return $this->accessToken;
        }

        return $this->requestNewAccessToken();
    }

    /**
     * Effectue l’appel HTTP vers le serveur OAuth et retourne un nouveau token.
     *
     * @throws AuthenticationException
     */
    private function requestNewAccessToken(): string
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->credentials->namUrl . '/token',
                [
                'body' => [
                    'grant_type'    => $this->credentials->grantType,
                    'client_id'     => $this->credentials->clientId,
                    'client_secret' => $this->credentials->clientSecret,
                    'username'      => $this->credentials->username,
                    'password'      => $this->credentials->password,
                    'scope'         => $this->credentials->scope,
                ],
                ]
            );

            if ($response->getStatusCode() !== 200) {
                throw new AuthenticationException('Invalid response code during OAuth authentication : ' . $response->getStatusCode() . ' ' . $response->getContent(false));
            }

            $data = $response->toArray(false);

            if (!isset($data['access_token'], $data['expires_in'])) {
                throw new AuthenticationException('Invalid OAuth response format.');
            }

            $this->accessToken = $data['access_token'];
            $this->expiresAt = (new DateTimeImmutable())
                ->modify('+' . ((int) $data['expires_in'] - 60) . ' seconds'); // 1 minute before expiration

            return $this->accessToken;
        } catch (\Throwable $e) {
            throw new AuthenticationException(
                'OAuth authentication failed: ' . $e->getMessage(),
                previous: $e
            );
        }
    }
}
