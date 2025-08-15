<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCours;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;
use Helip\SielEsahrClient\Dto\Common\SubventionResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * Doc: 4.8.1.4.2 {inscription}{inscription}
 *
 * @internal
 */
final readonly class InscriptionCoursItemResponseDto extends AbstractResponseDto
{
    /**
     * @param int                                 $idInscr                     Identifiant unique de
     *                                                                         l’inscription cours
     * @param int                                 $statusCode                  Statut de l’inscription (1 = valide, 0
     *                                                                         = annulé)
     * @param InscriptionCoursDataDto             $inscriptionCoursData        Données de base de l’inscription (date,
     *                                                                         cours, filière…)
     * @param InscriptionCoursSpecificityDto|null $inscriptionCoursSpecificity Spécificités liées au cours (groupe, prof, abandon, réussite…)
     * @param RegulariteInputDto|null             $regularity                  Régularité de l’élève dans le cours (flag,
     *                                                                         motif, date)
     * @param SubventionResponseDto|null          $subvention                  Subventionnement (flag, motif, date, commentaire)
     */
    public function __construct(
        public int $idInscr,
        public int $statusCode,
        public InscriptionCoursDataDto $inscriptionCoursData,
        public ?InscriptionCoursSpecificityDto $inscriptionCoursSpecificity,
        public ?RegulariteInputDto $regularity,
        public ?SubventionResponseDto $subvention,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['idInscr'], $data['statusCode'], $data['inscriptionCoursData'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: required keys "idInscr", "statusCode", or "inscriptionCoursData" are missing.'
            );
        }

        return new self(
            idInscr: $data['idInscr'],
            statusCode: $data['statusCode'],
            inscriptionCoursData: InscriptionCoursDataDto::fromArray($data['inscriptionCoursData']),
            inscriptionCoursSpecificity: isset($data['inscriptionCoursSpecificity']) ? InscriptionCoursSpecificityDto::fromArray($data['inscriptionCoursSpecificity']) : null,
            regularity: isset($data['regularity']) ? RegulariteInputDto::fromArray($data['regularity']) : null,
            subvention: isset($data['subvention']) ? SubventionResponseDto::fromArray($data['subvention']) : null,
        );
    }
}
