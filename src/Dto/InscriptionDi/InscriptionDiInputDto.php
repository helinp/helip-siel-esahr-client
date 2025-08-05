<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionDi;

use Helip\SielEsahrClient\Dto\Common\OrdreDiInputDto;
use Helip\SielEsahrClient\ValueObject\StatusCode;

/**
 * Utilisé pour modifier les champs relattifs aux droits d'inscription
 *
 * @internal
 */
final readonly class InscriptionDiInputDto
{
    public function __construct(
        public StatusCode $statusCode,
        public ?string $exemptionCode = null,
        public ?InscriptionDiOptionalDto $inscriptionDiOptional = null,
        public ?OrdreDiInputDto $annexeK1 = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
            'statusCode'            => $this->statusCode->value(),
            'exemptionCode'         => $this->exemptionCode,
            'inscriptionDiOptional' => $this->inscriptionDiOptional?->toArray(),
            'annexeK1'              => $this->annexeK1?->toArray(),
            ]
        );
    }
}
