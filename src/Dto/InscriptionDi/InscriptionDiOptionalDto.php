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
        public ?Indicator $payment,
        public ?IndicatorNA $attestation,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        foreach (['payment', 'attestation'] as $key) {
            if (isset($data[$key]) && !is_array($data[$key])) {
                throw new EsahrApiResponseException(
                    sprintf('Invalid response format: "%s" key is not an array.', $key)
                );
            }
        }

        return new self(
            payment: isset($data['payment']) ? new Indicator($data['payment']) : null,
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
