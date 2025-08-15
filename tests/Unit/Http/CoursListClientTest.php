<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeItemResponseDto;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeRequestDto;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeResponseDto;
use Helip\SielEsahrClient\Http\Client\CoursListClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(CoursListClient::class)]
final class CoursListClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): CoursListeRequestDto
    {
        return new CoursListeRequestDto(
            situationDate: new DateTimeImmutable('2023-01-01'),
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'cours_liste_response.json',
            clientClassName: CoursListClient::class,
            endpoint: 'listCours?situationDate=2023-01-01',
        );
    }

    #[CoversMethod(CoursListClient::class, 'list')]
    public function testListResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'list',
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(CoursListeResponseDto::class, $response);
        $this->assertEquals(
            388,
            $response->total
        );

        $CoursListeItemResponseDto = $response->items[0];
        $this->assertInstanceOf(
            CoursListeItemResponseDto::class,
            $CoursListeItemResponseDto
        );
    }
}
