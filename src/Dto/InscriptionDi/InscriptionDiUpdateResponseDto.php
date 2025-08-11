<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionDi;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Common\ComptabilisationDto;
use Helip\SielEsahrClient\Dto\Common\OrdreDiInputDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Modifier les droits d'inscription (4.5.1) / Réponse
 */
final readonly class InscriptionDiUpdateResponseDto extends AbstractResponseDto
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $schoolYear,
        public int $idEtab,
        public ?int $statusCode = null,
        public ?int $exemptionCode = null,
        public ?InscriptionDiOptionalDto $inscriptionDiOptional = null,
        public ?OrdreDiInputDto $ordreDi = null,
        public ?ComptabilisationDto $comptabilisation = null
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['inscription']) || !is_array($data['inscription'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "inscription" key is missing or not an array.'
            );
        }

        $data = $data['inscription'];

        return new self(
            idEsahr: new IdEsahr($data['idEsahr']),
            schoolYear: $data['schoolYear'],
            idEtab: $data['idEtab'],
            statusCode: $data['statusCode'] ?? null,
            exemptionCode: $data['exemptionCode'] ?? null,
            inscriptionDiOptional: isset($data['inscriptionDiOptional']) ? InscriptionDiOptionalDto::fromArray($data['inscriptionDiOptional']) : null,
            ordreDi: isset($data['ordreDi']) ? OrdreDiInputDto::fromArray($data['ordreDi']) : null,
            comptabilisation: isset($data['comptabilisation']) ? ComptabilisationDto::fromArray($data['comptabilisation']) : null
        );
    }
}
