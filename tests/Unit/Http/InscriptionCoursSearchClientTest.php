<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursDataDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchMultipleResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchResponseDto;
use Helip\SielEsahrClient\Http\Client\InscriptionCoursSearchClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(InscriptionCoursSearchClient::class)]
final class InscriptionCoursSearchClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): InscriptionCoursSearchRequestDto
    {
        return new InscriptionCoursSearchRequestDto(
            idEsahr: new IdEsahr('00007-47'),
            idEtab: 12345,
            schoolYear: 2023,
            situationDate: new DateTimeImmutable('2023-09-01')
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'inscription_cours_search_response.json',
            clientClassName: InscriptionCoursSearchClient::class,
            endpoint: 'inscriptionCours?idEsahr=00007-47&idEtab=12345&schoolYear=2023&situationDate=2023-09-01',
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

        $this->assertInstanceOf(InscriptionCoursSearchMultipleResponseDto::class, $response);
        $this->assertSame(2, $response->total);

        $this->assertInstanceOf(InscriptionCoursSearchResponseDto::class, $response->items[0]);
        $this->assertSame('00001-41', $response->items[0]->idEsahr->value());

        $inscriptionCoursData = $response->items[0]->inscriptionCoursData;
        $this->assertInstanceOf(InscriptionCoursDataDto::class, $inscriptionCoursData);
        $this->assertSame('2021-09-10', $inscriptionCoursData->inscriptionDate->format('Y-m-d'));
    }
}
