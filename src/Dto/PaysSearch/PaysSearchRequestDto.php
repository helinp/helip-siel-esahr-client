<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\PaysSearch;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;

/**
 * Recherche des pays (4.11) / Requête
 */
final readonly class PaysSearchRequestDto implements RequestDtoInterface
{
    public function __construct(
        public string $name
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name
        ];
    }
}
