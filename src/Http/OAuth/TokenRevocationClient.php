<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\OAuth;

use Helip\SielEsahrClient\Dto\OAuth\Credentials;
use Helip\SielEsahrClient\Exception\AuthenticationException;
use Helip\SielEsahrClient\Http\Transport\NamHttpClientInterface;

final class TokenRevocationClient
{
    public function __construct(
        private readonly NamHttpClientInterface $namHttpClient,
        private readonly Credentials $credentials
    ) {
    }

    public function revokeToken(string $accessToken): void
    {
        try {
            $this->namHttpClient->post(
                'revoke',
                $accessToken,
                [
                    'client_id'     => $this->credentials->clientId,
                    'client_secret' => $this->credentials->clientSecret,
                    'token'         => $accessToken,
                ]
            );
        } catch (\Throwable $e) {
            throw new AuthenticationException('Impossible de révoquer le token : ' . $e->getMessage(), previous: $e);
        }
    }
}
