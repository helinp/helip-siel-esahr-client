<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum IndicatorOnHoldEnum: string
{
    case O = 'O';
    case N = 'N';
    case A = 'A';

    public function label(): string
    {
        return match ($this) {
            self::O => 'Oui',
            self::N => 'Non',
            self::A => 'En attente',
        };
    }
}
