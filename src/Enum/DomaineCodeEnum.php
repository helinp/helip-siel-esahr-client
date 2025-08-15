<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum DomaineCodeEnum: string
{
    case MU   = 'MU';
    case DA   = 'DA';
    case APT  = 'APT';
    case APVE = 'APVE';

    public function label(): string
    {
        return match ($this) {
            self::MU   => 'Musique',
            self::DA   => 'Danse',
            self::APT  => 'Arts de la parole',
            self::APVE => 'Arts plastiques, visuels et de l’espace',
        };
    }
}
