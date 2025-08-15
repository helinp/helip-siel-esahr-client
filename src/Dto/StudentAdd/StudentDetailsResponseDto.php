<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\StudentAdd;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Student\StudentDetailResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Sauvegarder un élève 4.3.1 / Réponse
 */
final readonly class StudentDetailsResponseDto extends AbstractResponseDto
{
    public function __construct(
        public ?IdEsahr $idEsahr,
        public ?StudentDetailResponseDto $rnDetails,
        public ?StudentDetailResponseDto $cfwbDetails,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        if (!isset($data['idEsahr']) || !is_string($data['idEsahr'])) {
            throw new EsahrApiResponseException('Invalid response format: "idEsahr" key is missing or not a string.');
        }

        return new self(
            idEsahr: isset($data['idEsahr']) ? new IdEsahr($data['idEsahr']) : null,
            rnDetails: isset($data['rnDetails']) ? StudentDetailResponseDto::fromArray($data['rnDetails']) : null,
            cfwbDetails: isset($data['cfwbDetails']) ? StudentDetailResponseDto::fromArray($data['cfwbDetails']) : null,
        );
    }
}
