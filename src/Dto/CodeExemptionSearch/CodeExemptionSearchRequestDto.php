<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CodeExemptionSearch;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;

/**
 * Recherche des codes d'exemption (4.2 / Page 66)
 * Pas de paramètre dans la requête
 */
final readonly class CodeExemptionSearchRequestDto implements RequestDtoInterface
{
    public function __construct()
    {
    }

    public function toArray(): array
    {
        return [];
    }
}
