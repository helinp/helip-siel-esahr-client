<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCoursSave;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursRequestItemDto;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Recherche les inscriptions aux cours (4.9) / Requête
 */
final readonly class InscriptionCoursSaveRequestDto implements RequestDtoInterface
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
            'idEsahr'     => $this->idEsahr->value(),
            'idEtab'      => $this->idEtab,
            'schoolYear'  => $this->schoolYear,
            'inscription' => $this->inscription->toArray()
        ];
    }
}
