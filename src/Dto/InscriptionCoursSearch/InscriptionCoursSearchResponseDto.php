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

        if (!isset($data['inscription']['inscription']) || !is_array($data['inscription']['inscription'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "inscription.inscription" key is missing or not an array.'
            );
        }

        $insc = $data['inscription'];

        return new self(
            idEsahr: new IdEsahr($insc['idEsahr']),
            schoolYear: (int) $insc['schoolYear'],
            idEtab: (int) $insc['idEtab'],
            inscriptionCoursData: InscriptionCoursDataDto::fromArray($insc['inscription']['inscriptionCoursData']),
            inscriptionCoursSpecificity: InscriptionCoursSpecificityDto::fromArray($insc['inscription']['inscriptionCoursSpecificity'] ?? []),
            regularity: RegulariteInputDto::fromArray($insc['inscription']['regularity'] ?? []),
            subvention: SubventionResponseDto::fromArray($insc['inscription']['subvention'] ?? []),
            warning: $insc['inscription']['warning'] ?? null
        );
    }
}
