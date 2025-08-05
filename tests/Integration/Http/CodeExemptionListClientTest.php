<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use Helip\SielEsahrClient\Dto\CodeExemptionSearch\CodeExemptionSearchResponseDto;
use Helip\SielEsahrClient\Dto\CodeExemptionSearch\CodeExemptionSearchItemResponseDto;
use Helip\SielEsahrClient\Dto\CodeExemptionSearch\CodeExemptionSearchItemCountryResponseDto;
use Helip\SielEsahrClient\Http\Client\CodeExemptionListClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;

final class CodeExemptionListClientTest extends AbstractEsahrClient
{
    private CodeExemptionListClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new CodeExemptionListClient($this->httpClient);
    }

    public function testListReturnsStructurallyValidResponse(): void
    {
        $accessToken = $this->getAccessToken();
        $result = $this->client->list($accessToken);

        $this->assertInstanceOf(CodeExemptionSearchResponseDto::class, $result);
        $this->assertIsArray($result->items);
        $this->assertNotEmpty($result->items);
        $this->assertIsInt($result->total);
        $this->assertGreaterThan(0, $result->total);

        $item = $result->items[0];
        $this->assertInstanceOf(CodeExemptionSearchItemResponseDto::class, $item);
    }
}
