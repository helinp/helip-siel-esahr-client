<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use Helip\SielEsahrClient\Http\Client\InscriptionCoursSearchClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchMultipleResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchRequestDto;

final class InscriptionCoursSearchClientTest extends AbstractEsahrClient
{
    private InscriptionCoursSearchClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new InscriptionCoursSearchClient($this->httpClient);
    }

    public function testSearchReturnsInscriptionCoursSearchResponseDto(): void
    {
        $accessToken = $this->getAccessToken();

        $request = new InscriptionCoursSearchRequestDto(
            idEsahr: new IdEsahr('1-01'), // valeur réaliste pour éviter exception
            idEtab: 593,
            schoolYear: 2023,
            situationDate: null,
        );

        $result = $this->client->search($accessToken, $request);

        $this->assertInstanceOf(InscriptionCoursSearchMultipleResponseDto::class, $result);
        $this->assertIsArray($result->items);
        $this->assertNotEmpty($result->items);

        foreach ($result->items as $item) {
            $this->assertInstanceOf(InscriptionCoursSearchResponseDto::class, $item);
            $this->assertGreaterThan(0, $item->idEtab);
            $this->assertGreaterThan(0, $item->schoolYear);
        }
    }
}
