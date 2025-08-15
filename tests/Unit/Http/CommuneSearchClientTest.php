<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchRequestDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchResponseDto;
use Helip\SielEsahrClient\Http\Client\CommuneSearchClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(CommuneSearchClient::class)]
final class CommuneSearchClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): CommuneSearchRequestDto
    {
        return new CommuneSearchRequestDto(
            nameCommune: null,
            nameLocality: 'Bruxelles',
            postalCode: '1190'
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'commune_search_response.json',
            clientClassName: CommuneSearchClient::class,
            endpoint: 'commune?nameLocality=Bruxelles&postalCode=1190',
        );
    }

    #[CoversMethod(CommuneSearchClient::class, 'search')]
    public function testSearchResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'search',
            arguments: [],
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(CommuneSearchResponseDto::class, $response);
        $this->assertSame(1, $response->total);
    }
}
