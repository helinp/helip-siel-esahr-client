<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\ValidationUpdate\ValidationUpdateRequestDto;
use Helip\SielEsahrClient\Dto\ValidationUpdate\ValidationUpdateResponseDto;
use Helip\SielEsahrClient\Http\Client\ValidationUpdateClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(ValidationUpdateClient::class)]
final class ValidationUpdateClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): ValidationUpdateRequestDto
    {
        return new ValidationUpdateRequestDto(
            idEtab: 1234,
            schoolYear: 2023,
            validationType: 'L1L2',
            source: 'DIR',
            date: new DateTimeImmutable('2021-02-15')
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'validation_update_response.json',
            clientClassName: ValidationUpdateClient::class,
            endpoint: 'validation?idEtab=1234&schoolYear=2023&validationType=L1L2&source=DIR&date=2021-02-15',
        );
    }

    #[CoversMethod(ValidationUpdateClient::class, 'update')]
    public function testUpdateResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'update',
            arguments: [],
            httpMethodName: 'post'
        );

        $this->assertInstanceOf(ValidationUpdateResponseDto::class, $response);
    }
}
