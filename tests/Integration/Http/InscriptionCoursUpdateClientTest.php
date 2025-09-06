<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursDataDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursRequestItemDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursSpecificityDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursUpdate\InscriptionCoursUpdateRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiUpdateResponseDto;
use Helip\SielEsahrClient\Enum\StatusCodeEnum;
use Helip\SielEsahrClient\Enum\DomaineCodeEnum;
use Helip\SielEsahrClient\Enum\FiliereCodeEnum;
use Helip\SielEsahrClient\Http\Client\InscriptionCoursUpdateClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final class InscriptionCoursUpdateClientTest extends AbstractEsahrClient
{
    private InscriptionCoursUpdateClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new InscriptionCoursUpdateClient($this->httpClient);
    }

    public function testInscriptionCoursUpdateRequestDto(): void
    {
        $accessToken = $this->getAccessToken();

        $request = new InscriptionCoursUpdateRequestDto(
            idEsahr: new IdEsahr('00001-41'),
            idEtab: 593,
            schoolYear: 2023,
            inscription: new InscriptionCoursRequestItemDto(
                statusCode: StatusCodeEnum::ACTIVE,
                inscriptionCoursData: new InscriptionCoursDataDto(
                    inscriptionDate: new DateTimeImmutable('2023-09-05'),
                    domaineCode: DomaineCodeEnum::MU,
                    coursCode: 1,
                    filiere: FiliereCodeEnum::FOR,
                    annee: '1',
                    periode: 1,
                ),
                inscriptionCoursSpecificity: new InscriptionCoursSpecificityDto(
                    abandonDate: null,
                    group: null,
                    timetable: null,
                    professor: null,
                    impl: null,
                    success: true,
                ),
                regularity: new RegulariteInputDto(
                    regularityFlag: true,
                    reasonRegularity: null,
                    reasonOther: null,
                )
            )
        );

        $idInscription = 1;
        $result = $this->client->update($accessToken, $idInscription, $request);

        $this->assertInstanceOf(InscriptionDiUpdateResponseDto::class, $result);
    }
}
