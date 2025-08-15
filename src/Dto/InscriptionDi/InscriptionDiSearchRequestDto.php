<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionDi;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Rechercher les droits d'inscription pour un établissement (4.5.2) / Requête
 */
final readonly class InscriptionDiSearchRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $etabResponsable,
        public int $schoolYear,
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr'    => $this->idEsahr->value(),
            'idEtab'     => $this->etabResponsable,
            'schoolYear' => $this->schoolYear,
        ];
    }
}
