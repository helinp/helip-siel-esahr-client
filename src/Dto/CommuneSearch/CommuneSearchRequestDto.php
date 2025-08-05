<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CommuneSearch;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;

/**
 * Recherche des communes (4.1) / Requête
 */
final readonly class CommuneSearchRequestDto implements RequestDtoInterface
{
    public function __construct(
        public ?string $nameCommune = null,
        public ?string $nameLocality = null,
        public ?string $postalCode = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'nameCommune' => $this->nameCommune,
            'nameLocality' => $this->nameLocality,
            'postalCode' => $this->postalCode,
        ];
    }
}
