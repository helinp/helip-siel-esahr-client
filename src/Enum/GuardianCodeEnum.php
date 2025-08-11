<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum GuardianCodeEnum: string
{
    case OTHER = 'A';
    case PARENT = 'P';
    case TUTOR = 'T';

    public function label(): string
    {
        return match ($this) {
            self::OTHER => 'Autre',
            self::PARENT => 'Parent',
            self::TUTOR => 'Tuteur',
        };
    }
}
