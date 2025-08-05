<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiSearchRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiSearchResponseDto;
use Helip\SielEsahrClient\Http\Client\DroitInscriptionSearchClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final class DroitInscriptionSearchClientTest extends AbstractEsahrClient
{
    private DroitInscriptionSearchClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new DroitInscriptionSearchClient($this->httpClient);
    }

    public function testSearchReturnsInscriptionDiResponseDto(): void
    {
        $accessToken = $this->getAccessToken();

        $request = new InscriptionDiSearchRequestDto(
            idEsahr: new IdEsahr('14434-78'),
            etabResponsable: 593,
            schoolYear: 2024
        );

        $result = $this->client->search($accessToken, $request);

        $this->assertInstanceOf(InscriptionDiSearchResponseDto::class, $result);
    }
}
