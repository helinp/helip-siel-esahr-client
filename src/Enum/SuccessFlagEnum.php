<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum SuccessFlagEnum: string
{
    case O = 'O';
    case N = 'N';

    public function label(): string
    {
        return match($this) {
            self::O => 'Succès',
            self::N => 'Echec',
        };
    }
}
