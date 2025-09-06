<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\Common\SubventionResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursDataDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursItemResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursRequestItemDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursSpecificityDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursUpdate\InscriptionCoursUpdateRequestDto;
use Helip\SielEsahrClient\Enum\DomaineCodeEnum;
use Helip\SielEsahrClient\Enum\FiliereCodeEnum;
use Helip\SielEsahrClient\Enum\StatusCodeEnum;
use Helip\SielEsahrClient\Http\Client\InscriptionCoursUpdateClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(InscriptionCoursUpdateClient::class)]
final class InscriptionCoursUpdateClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): InscriptionCoursUpdateRequestDto
    {
        return new InscriptionCoursUpdateRequestDto(
            idEsahr: new IdEsahr('00007-47'),
            idEtab: 123,
            schoolYear: 2023,
            inscription: new InscriptionCoursRequestItemDto(
                statusCode: StatusCodeEnum::ACTIVE,
                inscriptionCoursData: new InscriptionCoursDataDto(
                    inscriptionDate: new DateTimeImmutable('2023-09-01'),
                    domaineCode: DomaineCodeEnum::APT,
                    coursCode: 456,
                    filiere: FiliereCodeEnum::FOR,
                    annee: 'F1',
                    periode: 1
                ),
                inscriptionCoursSpecificity: new InscriptionCoursSpecificityDto(
                    abandonDate: null,
                    group: 'A',
                    timetable: 'Lundi 10h-12h',
                    professor: 'Professeur X',
                    impl: 'Implémentation Y',
                    success: true
                ),
                regularity: new RegulariteInputDto(
                    regularityFlag: true,
                    reasonRegularity: null,
                    reasonOther: null
                )
            )
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'inscription_cours_update.json',
            clientClassName: InscriptionCoursUpdateClient::class,
            endpoint: 'inscriptionCours?idInscript=52847',
        );
    }

    #[CoversMethod(InscriptionCoursUpdateClient::class, 'update')]
    public function testUpdateResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'update',
            arguments: [
                52847,
                $this->getRequestMock(),
            ], // Les arguments sont passés dans le mock
            httpMethodName: 'put'
        );

        $this->assertInstanceOf(InscriptionCoursResponseDto::class, $response);
        $this->assertEquals(new IdEsahr('00007-47'), $response->idEsahr);
        $this->assertInstanceOf(InscriptionCoursItemResponseDto::class, $response->inscriptionCoursData);

        $coursData = $response->inscriptionCoursData;
        $this->assertInstanceOf(InscriptionCoursSpecificityDto::class, $coursData->inscriptionCoursSpecificity);
        $this->assertInstanceOf(RegulariteInputDto::class, $coursData->regularity);
        $this->assertInstanceOf(SubventionResponseDto::class, $coursData->subvention);
    }
}
