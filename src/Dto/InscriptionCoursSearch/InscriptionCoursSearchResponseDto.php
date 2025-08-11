<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCoursSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\Common\SubventionResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursDataDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursSpecificityDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final readonly class InscriptionCoursSearchResponseDto extends AbstractResponseDto
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $schoolYear,
        public int $idEtab,
        public int $statusCode,
        public string $idInscr,
        public InscriptionCoursDataDto $inscriptionCoursData,
        public ?InscriptionCoursSpecificityDto $inscriptionCoursSpecificity,
        public ?RegulariteInputDto $regularity,
        public ?SubventionResponseDto $subvention,
        public ?string $warning = null,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        if (!isset($data['inscription']) || !is_array($data['inscription'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "inscription" key is missing or not an array.'
            );
        }

        $insc = $data['inscription'];

        return new self(
            idEsahr: new IdEsahr($insc['idEsahr']),
            schoolYear: (int) $insc['schoolYear'],
            idEtab: (int) $insc['idEtab'],
            statusCode: (int) $insc['statusCode'],
            idInscr: $insc['idInscr'],
            inscriptionCoursData: InscriptionCoursDataDto::fromArray($insc['inscriptionCoursData']),
            inscriptionCoursSpecificity: InscriptionCoursSpecificityDto::fromArray($insc['inscriptionCoursSpecificity'] ?? []),
            regularity: RegulariteInputDto::fromArray($insc['regularity'] ?? []),
            subvention: SubventionResponseDto::fromArray($insc['subvention'] ?? []),
            warning: $insc['warning'] ?? null
        );
    }
}
