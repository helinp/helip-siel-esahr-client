<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchRequestDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiException;
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

    #[CoversMethod(CommuneSearchClient::class, 'search')]
    public function testSearchResponseDTO(): void
    {

        $this->setUpTest(
            mockFileName: 'commune_search_response.json',
            clientClassName: CommuneSearchClient::class,
            endpoint: 'commune?nameLocality=Bruxelles&postalCode=1190',
        );

        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'search',
            arguments: [],
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(CommuneSearchResponseDto::class, $response);
        $this->assertSame(1, $response->total);
    }

    #[CoversMethod(CommuneSearchClient::class, 'search')]
    public function testSearchErrorResponseDTO(): void
    {

        $this->setUpTest(
            mockFileName: 'commune_search_error_response.json',
            clientClassName: CommuneSearchClient::class,
            endpoint: 'commune?nameLocality=Bruxelles&postalCode=1190',
        );

        $this->expectException(EsahrApiException::class);

        try {
            $this->getClientResponse(
                testedMethodName: 'search',
                arguments: [],
                httpMethodName: 'get'
            );
        } catch (EsahrApiException $e) {
            // Vérification des champs
            $this->assertSame(400, $e->problemDetails->status);
            $this->assertSame('Invalid Request', $e->problemDetails->title);
            $this->assertSame('One or more parameters are invalid.', $e->problemDetails->detail);
            throw $e; // Rejette l'exception pour que le test la capture
        }

        $this->fail('Expected EsahrApiException not thrown');
    }
}
