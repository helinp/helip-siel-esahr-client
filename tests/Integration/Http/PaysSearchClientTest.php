<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchRequestDto;
use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchResponseDto;
use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchItemResponseDto;
use Helip\SielEsahrClient\Http\Client\PaysSearchClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;

// ok
final class PaysSearchClientTest extends AbstractEsahrClient
{
    private PaysSearchClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new PaysSearchClient($this->httpClient);
    }

    public function testSearchReturnsStructurallyValidResponse(): void
    {
        $accessToken = $this->getAccessToken();
        $request = new PaysSearchRequestDto(name: 'Belgique');

        $result = $this->client->search($accessToken, $request);

        $this->assertInstanceOf(PaysSearchResponseDto::class, $result);
        $this->assertIsArray($result->items);
        $this->assertNotEmpty($result->items);
        $this->assertIsInt($result->total);
        $this->assertGreaterThan(0, $result->total);

        $item = $result->items[0];
        $this->assertInstanceOf(PaysSearchItemResponseDto::class, $item);

        $this->assertIsString($item->codeOnss);
        $this->assertInstanceOf(DateTimeImmutable::class, $item->dateStart);
        $this->assertInstanceOf(DateTimeImmutable::class, $item->dateEnd);
        $this->assertIsString($item->codeIso);
        $this->assertIsString($item->codeIso3);
        $this->assertIsString($item->name);
        $this->assertIsString($item->longName);
    }
}
