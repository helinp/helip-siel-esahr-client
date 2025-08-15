<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\ValidationSearch;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final readonly class ValidationSearchRequestDto implements RequestDtoInterface
{
    public function __construct(
        public int $schoolYear,
        public ?int $idEtab,
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEtab' => $this->idEtab,
            'schoolYear' => $this->schoolYear,
        ];
    }
}
