<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineSearch\InscriptionRegulariteDomaineItemResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineSearch\InscriptionRegulariteDomaineMultipleResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineSearch\InscriptionRegulariteDomaineRequestDto;
use Helip\SielEsahrClient\Http\Client\InscriptionRegulariteDomaineSearchClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(InscriptionRegulariteDomaineSearchClient::class)]
final class InscriptionRegulariteDomaineSearchClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): InscriptionRegulariteDomaineRequestDto
    {
        return new InscriptionRegulariteDomaineRequestDto(
            idEsahr: new IdEsahr('15678-92'),
            idEtab: 12345,
            schoolYear: 2023
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'inscription_regularite_search_response.json',
            clientClassName: InscriptionRegulariteDomaineSearchClient::class,
            endpoint: 'inscriptionRegulariteDomaine?idEsahr=15678-92&idEtab=12345&schoolYear=2023',
        );
    }

    #[CoversMethod('search')]
    public function testSearchResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'search',
            arguments: [], // Les arguments sont passés dans le mock
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(InscriptionRegulariteDomaineMultipleResponseDto::class, $response);
        $this->assertSame(2, $response->total);

        $this->assertInstanceOf(InscriptionRegulariteDomaineItemResponseDto::class, $response->items[0]);
        $this->assertSame(2023, $response->items[0]->schoolYear);
    }
}
