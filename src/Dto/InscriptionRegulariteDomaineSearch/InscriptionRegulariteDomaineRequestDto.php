<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineSearch;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**

 */
final readonly class InscriptionRegulariteDomaineRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $idEtab,
        public int $schoolYear
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr'    => $this->idEsahr->value(),
            'idEtab'     => $this->idEtab,
            'schoolYear' => $this->schoolYear,
        ];
    }
}
