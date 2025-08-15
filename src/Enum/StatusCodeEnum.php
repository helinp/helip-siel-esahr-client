<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum StatusCodeEnum: int
{
    case CANCELLED = 0;
    case ACTIVE    = 1;

    public function label(): string
    {
        return match ($this) {
            self::CANCELLED => 'Annulé',
            self::ACTIVE    => 'Actif',
        };
    }
}
