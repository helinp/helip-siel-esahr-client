<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CoursList;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\RequestDtoInterface;

/**
 * Lister les cours (4.7.1) / Requête
 */
final readonly class CoursListeRequestDto implements RequestDtoInterface
{
    public function __construct(
        public ?DateTimeImmutable $situationDate
    ) {
    }

    public function toArray(): array
    {
        return [
            'situationDate' => $this->situationDate?->format('Y-m-d'),
        ];
    }
}
