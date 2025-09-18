<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCours;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\Exception\EsahrNoChangeResponseException;
use Helip\SielEsahrClient\Utils\SielResponseUtils;
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
        public InscriptionCoursItemResponseDto $inscriptionCoursData,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        // Gestion du cas particulier “200 / no change” retourné par l’API SIEL-ESAHR
        if (SielResponseUtils::isProblemDetails($data)) {
            $data = SielResponseUtils::toProblemDetails($data);

            throw new EsahrNoChangeResponseException(
                $data['title'],
                $data['detail'],
                $data['status'],
                $data['type'],
                $data['instance'],
                $data['id']
            );
        }

        if (!isset($data['inscription']) || !is_array($data['inscription'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "inscription" key is missing or not an array.'
            );
        }

        $data = $data['inscription'];

        return new self(
            idEsahr: new IdEsahr($data['idEsahr']),
            idEtab: $data['idEtab'],
            schoolYear: $data['schoolYear'],
            inscriptionCoursData: InscriptionCoursItemResponseDto::fromArray($data['inscription']),
        );
    }
}
