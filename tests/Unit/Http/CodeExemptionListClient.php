<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\CodeExemptionSearch\CodeExemptionSearchItemResponseDto;
use Helip\SielEsahrClient\Dto\CodeExemptionSearch\CodeExemptionSearchResponseDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CodeExemptionSearchRequestDto;
use Helip\SielEsahrClient\Http\Client\CodeExemptionListClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(CodeExemptionListClient::class)]
final class CodeExemptionListClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): CodeExemptionSearchRequestDto
    {
        return new CodeExemptionSearchRequestDto();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'code_exemption_response.json',
            clientClassName: CodeExemptionListClient::class,
            endpoint: 'exemption_code',
        );
    }

    #[CoversMethod(CodeExemptionListClient::class, 'list')]
    public function testSaveResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'save',
            httpMethodName: 'post'
        );

        $this->assertInstanceOf(CodeExemptionSearchResponseDto::class, $response);
        $this->assertSame(18, $response->total);
        $this->assertInstanceOf(CodeExemptionSearchItemResponseDto::class, $response->items[0]);
        $this->assertSame('Pas de réduction', $response->items[0]->text);
    }
}
