<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum GenderCodeEnum: string
{
    case MALE    = 'M';
    case FEMALE  = 'F';
    case UNKNOWN = 'A';

    public function label(): string
    {
        return match ($this) {
            self::MALE    => 'Masculin',
            self::FEMALE  => 'Féminin',
            self::UNKNOWN => 'Autre / Indéfini',
        };
    }
}
