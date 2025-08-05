<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\ValidationUpdate;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\RequestDtoInterface;

final readonly class ValidationUpdateRequestDto implements RequestDtoInterface
{
    public function __construct(
        public int $idEtab,
        public int $schoolYear,
        public string $validationType,
        public string $source,
        public DateTimeImmutable $date
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEtab' => $this->idEtab,
            'schoolYear' => $this->schoolYear,
            'validationType' => $this->validationType,
            'source' => $this->source,
            'date' => $this->date->format('Y-m-d'),
        ];
    }
}
