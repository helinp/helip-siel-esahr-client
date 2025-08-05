<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\ValidationSearch;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final readonly class ValidationSearchRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr,
        public int $schoolYear,
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr' => $this->idEsahr->value(),
            'schoolYear' => $this->schoolYear,
        ];
    }
}
