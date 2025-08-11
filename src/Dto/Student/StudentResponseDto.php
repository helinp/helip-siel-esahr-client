<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Student;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Single student response DTO
 */
final readonly class StudentResponseDto extends AbstractResponseDto
{
    /**
     * @param StudentDetailResponseDto|null $rnDetail   Données Registre National (pas encore implémenté)
     * @param StudentDetailResponseDto|null $cfwbDetail Données CFWB
     */
    public function __construct(
        public ?IdEsahr $idEsahr,
        public ?StudentDetailResponseDto $rnDetail,
        public ?StudentDetailResponseDto $cfwbDetail,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        if (!isset($data['students']) || !is_array($data['students'])) {
            throw new EsahrApiResponseException(
                sprintf("Invalid response data for %s: 'students' key is missing or not an array", static::class)
            );
        }

        $data = $data['students'];
        return new self(
            idEsahr: (new IdEsahr($data['idEsahr']) ?? ''),
            rnDetail: isset($data['rnDetail']) ? StudentDetailResponseDto::fromArray($data['rnDetail']) : null,
            cfwbDetail: isset($data['cfwbDetail']) ? StudentDetailResponseDto::fromArray($data['cfwbDetail']) : null,
        );
    }
}
