<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\Contract\ResponseDtoInterface;
use Helip\SielEsahrClient\Http\Transport\EsahrHttpClientInterface;
use PHPUnit\Framework\TestCase;

abstract class ClientTestAbstract extends TestCase
{
    /**
     * Retourne le DTO de requête à utiliser pour les tests.
     */
    abstract protected function getRequestMock(): ?RequestDtoInterface;

    private string $mockFileName;
    private string $clientClassName;
    private string $endpoint;

    protected function setUpTest(
        string $mockFileName,
        string $clientClassName,
        string $endpoint
    ) {
        $this->mockFileName = $mockFileName;
        $this->clientClassName = $clientClassName;
        $this->endpoint = $endpoint;
    }

    private function getJsonMock(): array
    {
        $fileName = $this->mockFileName;
        $filePath = __DIR__ . '/../../Fixtures/Http/' . $fileName;
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Mock file not found: $filePath");
        }
        return json_decode(file_get_contents($filePath), true, 512, JSON_THROW_ON_ERROR);
    }


    /**
     * Retourne la réponse du client pour la méthode spécifiée.
     *
     * @param string $testedMethodName Nom de la méthode à tester sur le client
     * @param callable $testResponseCallback Callback pour vérifier la réponse (doit retourner un booléen
     * @param array $testResponseArguments Arguments supplémentaires pour le callback de vérification
     * @param string $httpMethodName Méthode HTTP à utiliser (par défaut 'get')
     */
    protected function getClientResponse(
        string $testedMethodName,
        array $arguments = [],
        string $httpMethodName = 'get'
    ): ResponseDtoInterface {

        // Fixture
        $mockData = $this->getJsonMock();

        // Mock du transport
        $mockTransport = $this->createMock(EsahrHttpClientInterface::class);
        $mockTransport
            ->expects($this->once())
            ->method($httpMethodName)
            ->with(
                $this->endpoint,
                'mock-access-token'

            )
            ->willReturn($mockData);

        // Client
        $stub = $this
            ->getMockBuilder($this->clientClassName)
            ->setConstructorArgs([$mockTransport])
            ->onlyMethods([]) // pas de méthode surchargée
            ->getMock();

        if($arguments === []) {
            $arguments = [$this->getRequestMock()];
        }

        return $stub->{$testedMethodName}(
            'mock-access-token',
            ...$arguments
        );
    }
}
