<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Common;

use Helip\SielEsahrClient\Enum\RaisonRegulariteEnum;
use InvalidArgumentException;

final readonly class RegulariteInputDto
{
    /**
     * @param bool                      $regularityFlag   'O' ou 'N' (true = 'O', false = 'N')
     * @param RaisonRegulariteEnum|null $reasonRegularity Code de motif d’irrégularité
     * @param string|null               $reasonOther      Détail libre du motif, requis si reasonRegularity
     *                                                    == AUTRE
     */
    public function __construct(
        public bool $regularityFlag,
        public ?RaisonRegulariteEnum $reasonRegularity,
        public ?string $reasonOther,
    ) {
        if ($this->reasonRegularity === RaisonRegulariteEnum::AUTRE && empty($this->reasonOther)) {
            throw new InvalidArgumentException("Le champ 'reasonOther' est requis lorsque reasonRegularity = AUTRE.");
        }
    }

    public function toArray(): array
    {
        return [
            'regularityFlag'   => $this->regularityFlag ? 'O' : 'N',
            'reasonRegularity' => $this->reasonRegularity?->value,
            'reasonOther'      => $this->reasonOther
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            regularityFlag: $data['regularityFlag'] === 'O',
            reasonRegularity: isset($data['reasonRegularity'])
                ? RaisonRegulariteEnum::from($data['reasonRegularity'])
                : null,
            reasonOther: $data['reasonOther'] ?? null,
        );
    }
}
