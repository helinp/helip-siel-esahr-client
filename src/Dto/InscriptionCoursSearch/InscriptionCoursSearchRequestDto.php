<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCoursSearch;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Recherche les inscriptions aux cours (4.9) / Requête
 */
final readonly class InscriptionCoursSearchRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $idEtab,
        public int $schoolYear,
        public ?DateTimeImmutable $situationDate,
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr' => $this->idEsahr->value(),
            'idEtab' => $this->idEtab,
            'schoolYear' => $this->schoolYear,
            'situationDate' => $this->situationDate?->format('Y-m-d'),
        ];
    }
}
