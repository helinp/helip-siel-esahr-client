<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineUpdate;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Enum\DomaineCodeEnum;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**

 */
final readonly class InscriptionRegulariteDomaineRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $idEtab,
        public int $schoolYear,
        public DomaineCodeEnum $coDomaine,
        public string $filiere,
        public RegulariteInputDto $inscriptionDomaine,
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr' => $this->idEsahr->value(),
            'idEtab' => $this->idEtab,
            'schoolYear' => $this->schoolYear,
            'coDomaine' => $this->coDomaine->value,
            'filiere' => $this->filiere,
            'inscriptionDomaine' => $this->inscriptionDomaine->toArray(),
        ];
    }
}
