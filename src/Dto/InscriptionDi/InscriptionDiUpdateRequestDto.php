<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionDi;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Modifier les droits d'inscription (4.5.1) / Requête
 */
final readonly class InscriptionDiUpdateRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $etabResponsable,
        public int $schoolYear,
        public InscriptionDiInputDto $inscriptionDi
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr'         => $this->idEsahr->value(),
            'etabResponsable' => $this->etabResponsable,
            'schoolYear'      => $this->schoolYear,
            'inscriptionDi'   => $this->inscriptionDi->toArray(), // Doc: InscriptionDiInput
        ];
    }
}
