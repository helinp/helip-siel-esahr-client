<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Common;

use DateTimeImmutable;
use Helip\SielEsahrClient\Enum\RaisonComptabilisationEnum;
use Helip\SielEsahrClient\ValueObject\Indicator;
use InvalidArgumentException;

/**
 * Information de comptabilisation de l’élève dans le DI (cf. doc §5.10.5)
 */
final readonly class ComptabilisationDto
{
    /**
     * @param Indicator                       $comptabilisationFlag   'O' : comptabilisé / 'N' :
     *                                                                non comptabilisé
     * @param RaisonComptabilisationEnum|null $reasonComptabilisation Motif de non-comptabilisation (si applicable)
     * @param string|null                     $reasonOther            Détail libre (obligatoire si reasonComptabilisation
     *                                                                == AUTRES)
     * @param DateTimeImmutable|null          $date                   Date de non-comptabilisation
     */
    public function __construct(
        public Indicator $comptabilisationFlag,
        public ?RaisonComptabilisationEnum $reasonComptabilisation,
        public ?string $reasonOther,
        public ?DateTimeImmutable $date,
    ) {
        if ($this->reasonComptabilisation === RaisonComptabilisationEnum::AUTRES && empty($this->reasonOther)) {
            throw new InvalidArgumentException("Le champ 'reasonOther' est requis si reasonComptabilisation = AUTRSE.");
        }
    }

    public function toArray(): array
    {
        return array_filter(
            [
            'comptabilisationFlag'   => $this->comptabilisationFlag->value(),
            'reasonComptabilisation' => $this->reasonComptabilisation?->value,
            'reasonOther'            => $this->reasonOther,
            'date'                   => $this->date?->format('Y-m-d'),
            ]
        );
    }

    public static function fromArray(array $data): static
    {
        return new self(
            comptabilisationFlag: new Indicator($data['comptabilisationFlag'] ?? 'N'),
            reasonComptabilisation: isset($data['reasonComptabilisation'])
                ? RaisonComptabilisationEnum::from($data['reasonComptabilisation'])
                : null,
            reasonOther: $data['reasonOther'] ?? null,
            date: isset($data['date'])
                ? DateTimeImmutable::createFromFormat('Y-m-d', $data['date'])
                : null,
        );
    }
}
