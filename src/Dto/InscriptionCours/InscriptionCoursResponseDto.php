<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCours;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Sauvegarde d'une inscription à un cours (4.8) / Réponse
 * Doc: 4.8.1.4.1 {inscription}
 */
final readonly class InscriptionCoursResponseDto extends AbstractResponseDto
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $idEtab,
        public int $schoolYear,
        public int $idInscr,
        public int $statusCode,
        public InscriptionCoursItemResponseDto $inscriptionCoursData,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        if (!isset($data['inscription']) || !is_array($data['inscription'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "inscription" key is missing or not an array.',
                0,
                null,
                $data
            );
        }
        
        $data = $data['inscription'];
        
        return new self(
            idEsahr: $data['idEsahr'],
            idEtab: $data['idEtab'],
            schoolYear: $data['schoolYear'],
            idInscr: $data['idInscr'],
            statusCode: $data['statusCode'],
            inscriptionCoursData: InscriptionCoursItemResponseDto::fromArray($data['inscriptionCoursData']),
        );
    }
}
