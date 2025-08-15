<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\SchoolPath;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Enum\FiliereCodeEnum;
use Helip\SielEsahrClient\Enum\DomaineCodeEnum;
use Helip\SielEsahrClient\Enum\SuccessFlagEnum;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Doc: 4.9.2
 *
 * @internal
 */
final readonly class SchoolPathItemResponseDto extends AbstractResponseDto
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $schoolYear,
        public int $idEtab,
        public DomaineCodeEnum $domaineCode,
        public int $coursCode,
        public FiliereCodeEnum $filiere,
        public string $annee, // Année de la formation
        public int $periode, // Nombre de périodes suivies
        public SuccessFlagEnum $success, // 'O' ou 'N'
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['schoolPath']) || !is_array($data['schoolPath'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "schoolPath" key is missing or not an array.'
            );
        }

        $data = $data['schoolPath'];

        return new self(
            idEsahr: new IdEsahr($data['idEsahr']),
            schoolYear: $data['schoolYear'],
            idEtab: $data['idEtab'],
            domaineCode: DomaineCodeEnum::from($data['domaineCode']),
            coursCode: $data['coursCode'],
            filiere: FiliereCodeEnum::from($data['filiere']),
            annee: $data['annee'],
            periode: $data['periode'],
            success: SuccessFlagEnum::from($data['success']),
        );
    }
}
