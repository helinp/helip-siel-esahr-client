<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCoursUpdate;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursRequestItemDto;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Met à jour les inscriptions aux cours (4.8.2) / Requête
 */
final readonly class InscriptionCoursUpdateRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $idEtab,
        public int $schoolYear,
        public InscriptionCoursRequestItemDto $inscription
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr' => $this->idEsahr->value(),
            'idEtab' => $this->idEtab,
            'schoolYear' => $this->schoolYear,
            'inscription' => $this->inscription->toArray()
        ];
    }
}
