<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiInputDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiUpdateRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiUpdateResponseDto;
use Helip\SielEsahrClient\Enum\StatusCodeEnum;
use Helip\SielEsahrClient\Http\Client\DroitInscriptionUpdateClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use Helip\SielEsahrClient\ValueObject\StatusCode;

final class DroitInscriptionUpdateClientTest extends AbstractEsahrClient
{
    private DroitInscriptionUpdateClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new DroitInscriptionUpdateClient($this->httpClient);
    }

    public function testUpdateReturnsInscriptionDiUpdateResponseDto(): void
    {

        $accessToken = $this->getAccessToken();

        $request = new InscriptionDiUpdateRequestDto(
            idEsahr: new IdEsahr('14434-78'),
            etabResponsable: 593,
            schoolYear: 2024,
            inscriptionDi: new InscriptionDiInputDto(
                statusCode: new StatusCode(StatusCodeEnum::ACTIVE->value),
                exemptionCode: null
            )
        );

        $result = $this->client->update($accessToken, $request);

        $this->assertInstanceOf(InscriptionDiUpdateResponseDto::class, $result);
    }
}
