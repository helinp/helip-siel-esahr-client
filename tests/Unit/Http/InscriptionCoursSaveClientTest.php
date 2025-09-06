<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursDataDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursItemResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursRequestItemDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursSpecificityDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSave\InscriptionCoursSaveRequestDto;
use Helip\SielEsahrClient\Enum\DomaineCodeEnum;
use Helip\SielEsahrClient\Enum\FiliereCodeEnum;
use Helip\SielEsahrClient\Enum\StatusCodeEnum;
use Helip\SielEsahrClient\Http\Client\InscriptionCoursSaveClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(InscriptionCoursSaveClient::class)]
final class InscriptionCoursSaveClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): InscriptionCoursSaveRequestDto
    {
        return new InscriptionCoursSaveRequestDto(
            idEsahr: new IdEsahr('00002-42'),
            idEtab: 123456,
            schoolYear: 2023,
            inscription: new InscriptionCoursRequestItemDto(
                statusCode: StatusCodeEnum::ACTIVE,
                inscriptionCoursData: new InscriptionCoursDataDto(
                    inscriptionDate: new DateTimeImmutable('2023-09-01'),
                    domaineCode: DomaineCodeEnum::APT,
                    coursCode: 123,
                    filiere: FiliereCodeEnum::QUAL,
                    annee: "P1",
                    periode: 1
                ),
                inscriptionCoursSpecificity: new InscriptionCoursSpecificityDto(
                    abandonDate: new DateTimeImmutable('2023-09-15'),
                    group: 'G1',
                    timetable: 'Emploi du temps',
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
            mockFileName: 'inscription_cours_save.json',
            clientClassName: InscriptionCoursSaveClient::class,
            endpoint: 'inscriptionCours',
        );
    }

    #[CoversMethod(InscriptionCoursSaveClient::class, 'update')]
    public function testUpdateResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'save',
            arguments: [], // Les arguments sont passés dans le mock
            httpMethodName: 'post'
        );

        $this->assertInstanceOf(InscriptionCoursResponseDto::class, $response);
        $this->assertEquals(new IdEsahr('00001-41'), $response->idEsahr);

        $inscriptionCoursItemResponseDto = $response->inscriptionCoursData;
        $this->assertInstanceOf(InscriptionCoursItemResponseDto::class, $inscriptionCoursItemResponseDto);
        $this->assertEquals(46201, $inscriptionCoursItemResponseDto->idInscr);
    }
}
