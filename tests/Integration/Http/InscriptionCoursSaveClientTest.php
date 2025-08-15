<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursSpecificityDto;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursDataDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursRequestItemDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSave\InscriptionCoursSaveRequestDto;
use Helip\SielEsahrClient\Enum\StatusCodeEnum;
use Helip\SielEsahrClient\Enum\DomaineCodeEnum;
use Helip\SielEsahrClient\Enum\FiliereCodeEnum;
use Helip\SielEsahrClient\Http\Client\InscriptionCoursSaveClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final class InscriptionCoursSaveClientTest extends AbstractEsahrClient
{
    private InscriptionCoursSaveClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new InscriptionCoursSaveClient($this->httpClient);
    }

    public function testInscriptionCoursSaveRequestDto(): void
    {
        $accessToken = $this->getAccessToken();

        $request = new InscriptionCoursSaveRequestDto(
            idEsahr: new IdEsahr('14434-78'),
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

        $result = $this->client->Save($accessToken, $request);

        $this->assertInstanceOf(InscriptionCoursRequestItemDto::class, $result);
    }
}
