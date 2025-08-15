<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchRequestDto;
use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchResponseDto;
use Helip\SielEsahrClient\Http\Client\PaysSearchClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(PaysSearchClient::class)]
final class PaysSearchClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): PaysSearchRequestDto
    {
        return new PaysSearchRequestDto(
            name: 'Belgique',
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'pays_search_response.json',
            clientClassName: PaysSearchClient::class,
            endpoint: 'country?name=Belgique',
        );
    }

    #[CoversMethod(PaysSearchClient::class, 'search')]
    public function testSearchResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'search',
            arguments: [],
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(PaysSearchResponseDto::class, $response);
    }
}
