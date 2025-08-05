<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\StudentSearch;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Rechercher un élève par idEsahr (4.4.1)
 */
final readonly class StudentSearchIdEsahrRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr,
        public ?DateTimeImmutable $fromDate
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr' => $this->idEsahr->value(),
            'fromDate' => $this->fromDate->format('Y-m-d'),
        ];
    }
}
