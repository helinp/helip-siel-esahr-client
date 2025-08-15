<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineUpdate;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\Common\SubventionResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**

 */
final readonly class InscriptionRegulariteDomaineResponseDto extends AbstractResponseDto
{
    public function __construct(
        public string $idEsahr,
        public int $idEtab,
        public int $schoolYear,
        public string $coDomaine,
        public string $filiere,
        public RegulariteInputDto $regularity,
        public SubventionResponseDto $subvention
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
            idEsahr: $data['idEsahr'],
            idEtab: $data['idEtab'],
            schoolYear: $data['schoolYear'],
            coDomaine: $data['coDomaine'],
            filiere: $data['filiere'],
            regularity: RegulariteInputDto::fromArray($data['regularity']),
            subvention: SubventionResponseDto::fromArray($data['subvention'])
        );
    }
}
