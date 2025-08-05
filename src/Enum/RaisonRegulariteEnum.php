<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum RaisonRegulariteEnum: int
{
    case ABANDON = 1;
    case PRESENCE_INSUFFISANTE = 2;
    case PAS_DROIT_INSCRIPTION = 3;
    case AUTRE = 4;

    public function label(): string
    {
        return match($this) {
            self::ABANDON => 'Abandon',
            self::PRESENCE_INSUFFISANTE => 'Présences insuffisantes',
            self::PAS_DROIT_INSCRIPTION => "Pas en ordre de droit d'inscription",
            self::AUTRE => 'Autre (motif à préciser)',
        };
    }
}
