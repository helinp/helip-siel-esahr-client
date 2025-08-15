<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiInputDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiUpdateRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiUpdateResponseDto;
use Helip\SielEsahrClient\Enum\StatusCodeEnum;
use Helip\SielEsahrClient\Exception\EsahrApiException;
use Helip\SielEsahrClient\Http\Client\DroitInscriptionUpdateClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use Helip\SielEsahrClient\ValueObject\StatusCode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(DroitInscriptionUpdateClient::class)]
final class DroitInscriptionUpdateClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): InscriptionDiUpdateRequestDto
    {
        return new InscriptionDiUpdateRequestDto(
            idEsahr: new IdEsahr('123456-01'),
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
    public function testUpdateResponseDTO(): void
    {
        $this->setUpTest(
            mockFileName: 'droit_inscription_update_response.json',
            clientClassName: DroitInscriptionUpdateClient::class,
            endpoint: 'inscriptionDi',
        );

        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'update',
            arguments: [], // Les arguments sont passés dans le mock
            httpMethodName: 'put'
        );

        $this->assertInstanceOf(InscriptionDiUpdateResponseDto::class, $response);
    }

    #[CoversMethod(DroitInscriptionUpdateClient::class, 'update')]
    public function testUpdateErrorResponseDTOValues(): void
    {

        $this->setUpTest(
            mockFileName: 'droit_inscription_update_error_response.json',
            clientClassName: DroitInscriptionUpdateClient::class,
            endpoint: 'inscriptionDi',
        );

        $this->expectException(EsahrApiException::class);

        try {
            $this->getClientResponse(
                testedMethodName: 'update',
                arguments: [],
                httpMethodName: 'put'
            );
        } catch (EsahrApiException $e) {
            $this->assertSame('No inscription found for this student this year', $e->problemDetails->detail);
            $this->assertSame(404, $e->problemDetails->status);
            $this->assertSame('No inscription found', $e->problemDetails->title);
            throw $e; // Rejette l'exception pour que le test la capture
        }

        $this->fail('Expected EsahrApiException not thrown');
    }
}
