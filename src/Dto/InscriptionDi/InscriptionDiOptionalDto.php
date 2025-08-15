<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionDi;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\Indicator;
use Helip\SielEsahrClient\ValueObject\IndicatorNA;

/**
 * Informations sur le paiement et l'attestation de l'inscription.
 *
 * @internal
 */
final readonly class InscriptionDiOptionalDto extends AbstractResponseDto
{
    public function __construct(
        public ?IndicatorNA $payment, // Note: Indiqué Indicator dans la doc, mais API retourne IndicatorNA
        public ?IndicatorNA $attestation,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        return new self(
            payment: isset($data['payment']) ? new IndicatorNA($data['payment']) : null, // Note: Indiqué Indicator dans la doc, mais API retourne IndicatorNA
            attestation: isset($data['attestation']) ? new IndicatorNA($data['attestation']) : null
        );
    }

    public function toArray(): array
    {
        return array_filter(
            [
            'payment' => $this->payment->value(),
            'attestation' => $this->attestation->value()
            ]
        );
    }
}
