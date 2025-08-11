<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum IndicatorNAEnum: string
{
    case O = 'O';
    case N = 'N';
    case NA = 'NA';

    public function label(): string
    {
        return match ($this) {
            self::O => 'Oui',
            self::N => 'Non',
            self::NA => 'Non Applicable',
        };
    }
}
