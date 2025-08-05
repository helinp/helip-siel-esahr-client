<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionDi;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Common\ComptabilisationDto;
use Helip\SielEsahrClient\Dto\Common\OrdreDiInputDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiOptionalDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Rechercher les droits d'inscription (4.5.2) / Réponse
 */
final readonly class InscriptionDiSearchResponseDto extends AbstractResponseDto
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $schoolYear,
        public int $idEtab,
        public int $statusCode,
        public int $inscriptionRight,
        public ?InscriptionDiOptionalDto $inscriptionDiOptional,
        public ?OrdreDiInputDto $ordreDi,
        public ?ComptabilisationDto $comptabilisation,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['inscription']) || !is_array($data['inscription'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "inscription" key is missing or not an array.',
                0,
                null,
                $data
            );
        }

        $data = $data['inscription'];

        return new self(
            idEsahr: new IdEsahr($data['idEsahr']),
            schoolYear: $data['schoolYear'],
            idEtab: $data['idEtab'],
            statusCode: $data['statusCode'],
            inscriptionRight: $data['inscriptionRight'],
            inscriptionDiOptional: isset($data['inscriptionDiOptional']) ? InscriptionDiOptionalDto::fromArray($data['inscriptionDiOptional']) : null,
            ordreDi: isset($data['ordreDi']) ? OrdreDiInputDto::fromArray($data['ordreDi']) : null,
            comptabilisation: isset($data['comptabilisation']) ? ComptabilisationDto::fromArray($data['comptabilisation']) : null
        );
    }
}
