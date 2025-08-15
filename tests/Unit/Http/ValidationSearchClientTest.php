<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\ValidationSearch\ValidationSearchItemResponseDto;
use Helip\SielEsahrClient\Dto\ValidationSearch\ValidationSearchMultipleResponseDto;
use Helip\SielEsahrClient\Dto\ValidationSearch\ValidationSearchRequestDto;
use Helip\SielEsahrClient\Dto\ValidationSearch\ValidationSearchResponseDto;
use Helip\SielEsahrClient\Http\Client\ValidationSearchClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(ValidationSearchClient::class)]
final class ValidationSearchClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): ValidationSearchRequestDto
    {
        return new ValidationSearchRequestDto(
            schoolYear: 2023,
            idEtab: null,
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'validation_search_response.json',
            clientClassName: ValidationSearchClient::class,
            endpoint: 'validation?idEtab=null&schoolYear=2023',
        );
    }

    #[CoversMethod(ValidationSearchClient::class, 'search')]
    public function testSearchResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'search',
            arguments: [],
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(ValidationSearchMultipleResponseDto::class, $response);
        $this->assertSame(2, $response->total);

        $validationSearchItemResponseDto = $response->items[0];
        $this->assertInstanceOf(ValidationSearchItemResponseDto::class, $validationSearchItemResponseDto);
        $this->assertSame('L1L2', $validationSearchItemResponseDto->validationType);
        $this->assertInstanceOf(DateTimeImmutable::class, $validationSearchItemResponseDto->dateValidation);
        $this->assertSame('2021-02-15', $validationSearchItemResponseDto->dateValidation->format('Y-m-d'));
    }
}
