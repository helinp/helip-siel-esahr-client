<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum NotificationMessageTypeEnum: string
{
    case REGUL = 'REGUL';
    case SUBV  = 'SUBV';
    case ELEVE = 'ELEVE';

    public function label(): string
    {
        return match ($this) {
            self::REGUL => 'Changement régularité',
            self::SUBV  => 'Changement subvention',
            self::ELEVE => 'Changement données élève',
        };
    }
}
