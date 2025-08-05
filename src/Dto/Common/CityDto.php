<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Common;

final readonly class CityDto
{
    /**
     * @param string $placeCode Code INS pour la commune/district - code INS à 5 chiffres si Belge
     * @param string $placeText Représente le libellé de la commune/lieu
     */
    public function __construct(
        public string $placeCode,
        public string $placeText,
    ) {
    }

    public function toArray(): array
    {
        return [
            'placeCode' => $this->placeCode,
            'placeText' => $this->placeText,
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            placeCode: $data['placeCode'],
            placeText: $data['placeText'],
        );
    }
}
