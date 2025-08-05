<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionDi;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Common\ComptabilisationDto;
use Helip\SielEsahrClient\Dto\Common\OrdreDiInputDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final readonly class InscriptionDiListResponseDto extends AbstractResponseDto
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $schoolYear,
        public int $idEtab,
        public int $statusCode,
        public int $inscriptionRight,
        public ?InscriptionDiOptionalDto $inscriptionDiOptional = null,
        public ?OrdreDiInputDto $ordreDi = null,
        public ?ComptabilisationDto $comptabilisation = null,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        foreach (['idEsahr', 'schoolYear', 'idEtab', 'statusCode', 'inscriptionRight'] as $key) {
            if (!isset($data[$key]) || !is_scalar($data[$key])) {
                throw new EsahrApiResponseException(
                    sprintf('Invalid response format: "%s" key is missing or not a scalar.', $key),
                    0,
                    null,
                    $data
                );
            }
        }
        return new self(
            idEsahr: $data['idEsahr'],
            schoolYear: $data['schoolYear'],
            idEtab: $data['idEtab'],
            statusCode: $data['statusCode'],
            inscriptionRight: $data['inscriptionRight'],
            inscriptionDiOptional: isset($data['inscriptionDiOptional']) ? InscriptionDiOptionalDto::fromArray($data['inscriptionDiOptional']) : null,
            ordreDi: isset($data['ordreDi']) ? OrdreDiInputDto::fromArray($data['ordreDi']) : null,
            comptabilisation: isset($data['comptabilisation']) ? ComptabilisationDto::fromArray($data['comptabilisation']) : null
        );
    }

}
