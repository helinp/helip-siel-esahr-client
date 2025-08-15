<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\SchoolPath\SchoolPathRequestDto;
use Helip\SielEsahrClient\Dto\SchoolPath\SchoolPathsResponseDto;
use Helip\SielEsahrClient\Http\Client\SchoolPathListClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(SchoolPathListClient::class)]
final class SchoolPathListClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): ?SchoolPathRequestDto
    {
        return new SchoolPathRequestDto(
            idEsahr: new IdEsahr('123456-01')
        );
    }

    #[CoversMethod(SchoolPathListClient::class, 'list')]
    public function testListResponseDTO(): void
    {
        $this->setUpTest(
            mockFileName: 'school_path_response.json',
            clientClassName: SchoolPathListClient::class,
            endpoint: 'schoolpath?idEsahr=123456-01',
        );

        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'list',
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(SchoolPathsResponseDto::class, $response);
        $this->assertSame((new IdEsahr('123456-01'))->value(), $response->items[0]->idEsahr->value());
    }
}
