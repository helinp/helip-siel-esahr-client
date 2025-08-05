<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\NotificationDetails;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\RequestDtoInterface;

/**
 * Obtenir des notifications (4.2) / Requête
 */
final readonly class NotificationDetailsRequestDto implements RequestDtoInterface
{
    public function __construct(
        public int $idEtab,
        public DateTimeImmutable $dateFrom,
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEtab' => $this->idEtab,
            'dateFrom' => $this->dateFrom->format('Y-m-d'),
        ];
    }

}
