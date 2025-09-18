<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiInputDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiUpdateRequestDto;
use Helip\SielEsahrClient\Enum\StatusCodeEnum;
use Helip\SielEsahrClient\Exception\EsahrApiException;
use Helip\SielEsahrClient\Exception\EsahrNoChangeResponseException;
use Helip\SielEsahrClient\Http\Client\DroitInscriptionUpdateClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use Helip\SielEsahrClient\ValueObject\StatusCode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(DroitInscriptionUpdateClient::class)]
final class DroitInscriptionNoChangeClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): InscriptionDiUpdateRequestDto
    {
        return new InscriptionDiUpdateRequestDto(
            idEsahr: new IdEsahr('00002-02'),
            etabResponsable: 123456,
            schoolYear: 2023,
            inscriptionDi: new InscriptionDiInputDto(
                statusCode: new StatusCode(StatusCodeEnum::ACTIVE->value),
                exemptionCode: null,
                inscriptionDiOptional: null,
                annexeK1: null
            )
        );
    }

    #[CoversMethod(DroitInscriptionUpdateClient::class, 'update')]
    public function testUpdateThrowsNoChangeException(): void
    {
        $this->setUpTest(
            mockFileName: 'droit_inscription_no_change_response.json',
            clientClassName: DroitInscriptionUpdateClient::class,
            endpoint: 'inscriptionDi',
            expectedStatusCode: 200
        );

        // Le client wrappe l'exception -> on attend EsahrApiException (comme dans votre code original)
        $this->expectException(EsahrNoChangeResponseException::class);
        $this->expectExceptionMessage('No changes detected');

        $this->getClientResponse(
            testedMethodName: 'update',
            arguments: [],
            httpMethodName: 'put'
        );
    }
}
