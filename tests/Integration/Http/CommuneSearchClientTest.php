<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchRequestDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchResponseDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchItemResponseDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchItemCountryResponseDto;
use Helip\SielEsahrClient\Http\Client\CommuneSearchClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;

// ok
final class CommuneSearchClientTest extends AbstractEsahrClient
{
    private CommuneSearchClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new CommuneSearchClient($this->httpClient);
    }

    /**
     * @dataProvider provideCommuneSearchRequests
     */
    public function testSearchReturnsStructurallyValidResponse(CommuneSearchRequestDto $request): void
    {
        $accessToken = $this->getAccessToken();
        $result = $this->client->search($accessToken, $request);

        $this->assertInstanceOf(CommuneSearchResponseDto::class, $result);
        $this->assertIsArray($result->items);
        $this->assertNotEmpty($result->items);
        $this->assertIsInt($result->total);
        $this->assertGreaterThan(0, $result->total);

        $item = $result->items[0];
        $this->assertInstanceOf(CommuneSearchItemResponseDto::class, $item);

        $this->assertIsString($item->codeIns);
        $this->assertIsString($item->nameCommune);
        $this->assertIsString($item->nameLocality);
        $this->assertIsString($item->postalCode);
    }

    public static function provideCommuneSearchRequests(): array
    {
        return [
            'Nom + code postal' => [
                new CommuneSearchRequestDto(nameCommune: 'Bruxelles', postalCode: '1190'),
            ],
        ];
    }
}
