<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Abstract;

use Helip\SielEsahrClient\Dto\OAuth\Credentials;
use Helip\SielEsahrClient\Http\OAuth\OAuthTokenProvider;
use Helip\SielEsahrClient\Http\Transport\EsahrHttpClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

abstract class AbstractEsahrClient extends TestCase {

    protected OAuthTokenProvider $tokenProvider;
    protected EsahrHttpClient $httpClient;

    private static ?string $cachedToken = null;

    protected function setUp(): void
    {
        $requiredEnv = [
            'ESAHR_API_URL',
            'ESAHR_NAM_URL',
            'ESAHR_CLIENT_ID',
            'ESAHR_CLIENT_SECRET',
            'ESAHR_USERNAME',
            'ESAHR_PASSWORD',
        ];

        foreach ($requiredEnv as $var) {
            if (empty($_ENV[$var] ?? '')) {
                $this->markTestSkipped("Variable d'environnement manquante : $var");
            }
        }

        $httpClient = HttpClient::create(['timeout' => 5]);

        $credentials = new Credentials(
            clientId:     $_ENV['ESAHR_CLIENT_ID'],
            clientSecret: $_ENV['ESAHR_CLIENT_SECRET'],
            username:     $_ENV['ESAHR_USERNAME'],
            password:     $_ENV['ESAHR_PASSWORD'],
            namUrl:       $_ENV['ESAHR_NAM_URL'],
            scope:        'profile',
            grantType:    'password',
        );

        $this->tokenProvider = new OAuthTokenProvider($httpClient, $credentials);
        $this->httpClient = new EsahrHttpClient($httpClient, $_ENV['ESAHR_API_URL']);
    }

    protected function getAccessToken(): string
    {
        if (self::$cachedToken === null) {
            self::$cachedToken = $this->tokenProvider->getAccessToken();
        }

        return self::$cachedToken;
    }
}

