<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Common;

use DateTimeImmutable;
use Helip\SielEsahrClient\ValueObject\IndicatorOnHold;
use Helip\SielEsahrClient\ValueObject\RaisonOrdreDi;
use InvalidArgumentException;

/**
 * Annexe K1
 * Voir doc ESAHR v1.5.18, chapitres 5.10.3 (ordreDiInput) et 5.10.4 (ordreDi)
 *
 * @internal
 */
final readonly class OrdreDiInputDto
{
    /**
     * @param IndicatorOnHold        $ordreDiFlag   'O' si en ordre, 'N' non et 'A' en attente
     * @param RaisonOrdreDi|null     $reasonOrdreDi Code de la raison si pas en ordre
     * @param string|null            $reasonOther   Champ libre, requis si reasonOrdreDi == AUTRE
     * @param DateTimeImmutable|null $date          Date de non-régularité (uniquement si
     *                                              ordreDi)
     */
    public function __construct(
        public IndicatorOnHold $ordreDiFlag,
        public ?RaisonOrdreDi $reasonOrdreDi,
        public ?string $reasonOther,
        public ?DateTimeImmutable $date,
    ) {
        if ($this->reasonOrdreDi?->value() === 'AUTRE' && empty($this->reasonOther)) {
            throw new InvalidArgumentException("Le champ 'reasonOther' est requis lorsque reasonOrdreDi = AUTRE.");
        }
    }

    public function toArray(): array
    {
        return array_filter(
            [
            'ordreDiFlag'    => $this->ordreDiFlag->value(),
            'reasonOrdreDi'  => $this->reasonOrdreDi?->value(),
            'reasonOther'    => $this->reasonOther,
            'date'           => $this->date?->format('Y-m-d'),
            ]
        );
    }

    public static function fromArray(array $data): static
    {
        return new self(
            ordreDiFlag: new IndicatorOnHold($data['ordreDiFlag'] ?? 'N'),
            reasonOrdreDi: isset($data['reasonOrdreDi'])
                ? new RaisonOrdreDi($data['reasonOrdreDi'])
                : null,
            reasonOther: $data['reasonOther'] ?? null,
            date: isset($data['date'])
                ? DateTimeImmutable::createFromFormat('Y-m-d', $data['date'])
                : null,
        );
    }
}
