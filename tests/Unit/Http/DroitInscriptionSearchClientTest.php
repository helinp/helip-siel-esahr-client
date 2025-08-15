<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiSearchRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiSearchResponseDto;
use Helip\SielEsahrClient\Http\Client\DroitInscriptionSearchClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(DroitInscriptionSearchClient::class)]
final class DroitInscriptionSearchClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): InscriptionDiSearchRequestDto
    {
        return new InscriptionDiSearchRequestDto(
            idEsahr: new IdEsahr('123456-01'),
            etabResponsable: 123456,
            schoolYear: 2023,
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'droit_inscription_search_response.json',
            clientClassName: DroitInscriptionSearchClient::class,
            endpoint: 'inscriptionDi?idEsahr=123456-01&idEtab=123456&schoolYear=2023',
        );
    }

    #[CoversMethod(DroitInscriptionSearchClient::class, 'search')]
    public function testSearchResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'search',
            arguments: [], // Les arguments sont passés dans le mock
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(InscriptionDiSearchResponseDto::class, $response);
        
    }
}
