<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Common;

use InvalidArgumentException;

final readonly class PrivateAddressDto
{
    /**
     * @param string      $addressStreet
     * @param string|null $addressNumber  Numéro de rue, composé de 4 caractères
     *                                    max
     * @param string|null $addressBox     Boîte
     *                                    postale
     * @param string      $addressPostal  Code postal (ex : 1040)
     * @param CityDto     $addressCity    Objet contenant code INS et nom de la commune
     * @param string      $addressCountry Code pays INS (Statbel, ONSS), ex: '150' pour Belgique
     */
    public function __construct(
        public string $addressStreet,
        public ?string $addressNumber,
        public ?string $addressBox,
        public string $addressPostal,
        public CityDto $addressCity,
        public string $addressCountry,
    ) {
        if ($this->addressNumber !== null && mb_strlen($this->addressNumber) > 4) {
            throw new InvalidArgumentException('addressNumber ne peut pas dépasser 4 caractères');
        }
    }

    public static function fromArray(array $data): static
    {
        return new self(
            addressStreet: $data['addressStreet'] ?? '',
            addressNumber: $data['addressNumber'] ?? null,
            addressBox: $data['addressBox'] ?? null,
            addressPostal: $data['addressPostal'] ?? '',
            addressCity: isset($data['addressCity']) && is_array($data['addressCity'])
                ? CityDto::fromArray($data['addressCity'])
                : throw new InvalidArgumentException("Missing or invalid addressCity"),
            addressCountry: $data['addressCountry'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'addressStreet' => $this->addressStreet,
            'addressNumber' => $this->addressNumber,
            'addressBox' => $this->addressBox,
            'addressPostal' => $this->addressPostal,
            'addressCity' => $this->addressCity->toArray(),
            'addressCountry' => $this->addressCountry,
        ];
    }
}
