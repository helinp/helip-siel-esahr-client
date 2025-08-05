<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCoursSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursDataDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursSpecificityDto;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\Common\SubventionResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

final readonly class InscriptionCoursSearchResponseItemDto extends AbstractResponseDto
{
    public function __construct(
        public int $statusCode,
        public string $idInscr,
        public InscriptionCoursDataDto $inscriptionCoursData,
        public ?InscriptionCoursSpecificityDto $inscriptionCoursSpecificity,
        public ?RegulariteInputDto $regularity,
        public ?SubventionResponseDto $subvention
    ) {
    }

    public static function fromArrayInterne(array $data): static
    {

        if (!isset($data['statusCode'], $data['idInscr'], $data['inscriptionCoursData'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: required keys are missing.',
                0,
                null,
                $data
            );
        }

        return new self(
            statusCode: (int) $data['statusCode'],
            idInscr: $data['idInscr'],
            inscriptionCoursData: InscriptionCoursDataDto::fromArray($data['inscriptionCoursData']),
            inscriptionCoursSpecificity: InscriptionCoursSpecificityDto::fromArray($data['inscriptionCoursSpecificity'] ?? []),
            regularity: RegulariteInputDto::fromArray($data['regularity'] ?? []),
            subvention: SubventionResponseDto::fromArray($data['subvention'] ?? [])
        );
    }
}
