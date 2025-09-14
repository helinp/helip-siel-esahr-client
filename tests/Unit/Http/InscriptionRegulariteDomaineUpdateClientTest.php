<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineUpdate\InscriptionRegulariteDomaineRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineUpdate\InscriptionRegulariteDomaineResponseDto;
use Helip\SielEsahrClient\Enum\DomaineCodeEnum;
use Helip\SielEsahrClient\Enum\RaisonRegulariteEnum;
use Helip\SielEsahrClient\Http\Client\InscriptionRegulariteDomaineUpdateClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(InscriptionRegulariteDomaineUpdateClient::class)]
final class InscriptionRegulariteDomaineUpdateClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): InscriptionRegulariteDomaineRequestDto
    {
        return new InscriptionRegulariteDomaineRequestDto(
            idEsahr: new IdEsahr('00007-07'),
            idEtab: 12345,
            schoolYear: 2023,
            coDomaine: DomaineCodeEnum::APVE,
            filiere: 'TRA',
            inscriptionDomaine: new RegulariteInputDto(
                regularityFlag: true,
                reasonRegularity: RaisonRegulariteEnum::AUTRE,
                reasonOther: '<string>'
            )
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'inscription_regularite_update_response.json',
            clientClassName: InscriptionRegulariteDomaineUpdateClient::class,
            endpoint: 'inscriptionRegulariteDomaine',
        );
    }

    #[CoversMethod('update')]
    public function testUpdateResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'update',
            arguments: [], // Les arguments sont passés dans le mock
            httpMethodName: 'put'
        );

        $this->assertInstanceOf(InscriptionRegulariteDomaineResponseDto::class, $response);
        $this->assertSame(2023, $response->schoolYear);
        $this->assertSame('APVE', $response->coDomaine);
    }
}
