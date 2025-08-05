<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Common;

use DateTimeImmutable;
use Helip\SielEsahrClient\Enum\SubventionReasonEnum;
use Helip\SielEsahrClient\ValueObject\Indicator;
use InvalidArgumentException;

/**
 * Données de subvention liées à une inscription cours (cf. doc 5.16)
 */
final readonly class SubventionResponseDto
{
    /**
     * @param Indicator                 $subventionFlag   Indique si l’inscription est subventionnée ('O' = oui,
     *                                                    'N' = non)
     * @param SubventionReasonEnum|null $reasonSubvention Motif de non-subventionnement
     * @param string|null               $reasonOther      Texte libre (requis si reasonSubvention == AUTRE)
     * @param DateTimeImmutable|null    $date             Date de non-subvention (format YYYY-MM-DD)
     */
    public function __construct(
        public Indicator $subventionFlag,
        public ?SubventionReasonEnum $reasonSubvention = null,
        public ?string $reasonOther = null,
        public ?DateTimeImmutable $date = null,
    ) {
        if ($this->reasonSubvention === SubventionReasonEnum::AUTRE && empty($this->reasonOther)) {
            throw new InvalidArgumentException("Le champ 'reasonOther' est requis si reasonSubvention = AUTRE.");
        }
    }

    public function toArray(): array
    {
        return [
            'subventionFlag'    => $this->subventionFlag->value(), // renvoie 'O' ou 'N'
            'reasonSubvention'  => $this->reasonSubvention?->value,
            'reasonOther'       => $this->reasonOther,
            'date'              => $this->date?->format('Y-m-d'),
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            subventionFlag: new Indicator($data['subventionFlag'] ?? 'N'),
            reasonSubvention: isset($data['reasonSubvention'])
                ? SubventionReasonEnum::from($data['reasonSubvention'])
                : null,
            reasonOther: $data['reasonOther'] ?? null,
            date: isset($data['date']) ? DateTimeImmutable::createFromFormat('Y-m-d', $data['date']) : null,
        );
    }
}
