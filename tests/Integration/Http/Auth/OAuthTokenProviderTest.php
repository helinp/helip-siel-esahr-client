<?php

namespace Helip\SielEsahrClient\Tests\Integration\Http\Auth;

use PHPUnit\Framework\TestCase;
use Helip\SielEsahrClient\Http\OAuth\OAuthTokenProvider;
use Helip\SielEsahrClient\Dto\OAuth\Credentials;
use Symfony\Component\HttpClient\HttpClient;

/**
 * @group integration
 * @covers \Helip\SielEsahrClient\Http\OAuth\OAuthTokenProvider
 */
final class OAuthTokenProviderTest extends TestCase
{
    private OAuthTokenProvider $provider;

    protected function setUp(): void
    {
        // Skip if integration env vars are not set
        if (empty($_ENV['ESAHR_NAM_URL'] ?? '')
            || empty($_ENV['ESAHR_CLIENT_ID'] ?? '')
            || empty($_ENV['ESAHR_CLIENT_SECRET'] ?? '')
            || empty($_ENV['ESAHR_USERNAME'] ?? '')
            || empty($_ENV['ESAHR_PASSWORD'] ?? '')
        ) {
            $this->markTestSkipped('Les variables d\'environnement ESAHR_* pour l\'intégration ne sont pas définies.');
        }

        // Créer un client HTTP réel vers le serveur de recette
        $httpClient = HttpClient::create([
            'timeout' => 5,
        ]);

        $credentials = new Credentials(
            clientId:     $_ENV['ESAHR_CLIENT_ID'],
            clientSecret: $_ENV['ESAHR_CLIENT_SECRET'],
            username:     $_ENV['ESAHR_USERNAME'],
            password:     $_ENV['ESAHR_PASSWORD'],
            namUrl:       $_ENV['ESAHR_NAM_URL'],
            scope:        'profile',
            grantType:    'password'
        );

        $this->provider = new OAuthTokenProvider($httpClient, $credentials);
    }

    public function testGetAccessTokenReturnsValidToken(): void
    {
        // Act
        $token = $this->provider->getAccessToken();

        // Assert
        $this->assertIsString($token, 'Le token devrait être une chaîne.');
        $this->assertNotEmpty($token, 'Le token ne doit pas être vide.');
    }
}
