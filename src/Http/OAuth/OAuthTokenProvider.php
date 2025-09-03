<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\OAuth;

use DateTimeImmutable;
use Helip\SielEsahrClient\Exception\AuthenticationException;
use Helip\SielEsahrClient\Dto\OAuth\Credentials;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class OAuthTokenProvider
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly Credentials $credentials,
        private readonly TokenStorageInterface $storage
    ) {
    }

    public function getAccessToken(): string
    {
        $cached = $this->storage->load();

        if ($cached !== null && $cached['expiresAt'] > new DateTimeImmutable()) {
            return $cached['token'];
        }

        return $this->requestNewAccessToken();
    }

    private function requestNewAccessToken(): string
    {
        $response = $this->httpClient->request('POST', $this->credentials->namUrl . '/token', [
            'body' => [
                'grant_type'    => $this->credentials->grantType,
                'client_id'     => $this->credentials->clientId,
                'client_secret' => $this->credentials->clientSecret,
                'username'      => $this->credentials->username,
                'password'      => $this->credentials->password,
                'scope'         => $this->credentials->scope,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new AuthenticationException('Invalid response code during OAuth authentication : ' . $response->getStatusCode() . ' ' . $response->getContent(false));
        }

        $data = $response->toArray(false);

        if (!isset($data['access_token'], $data['expires_in'])) {
            throw new AuthenticationException('Invalid OAuth response format.');
        }

        $token     = $data['access_token'];
        $expiresAt = (new DateTimeImmutable())->modify('+' . ((int)$data['expires_in'] - 60) . ' seconds');

        $this->storage->save($token, $expiresAt);

        return $token;
    }
}
