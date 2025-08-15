<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum FiliereCodeEnum: string
{
    case PRE    = 'PRE';
    case FOR    = 'FOR';
    case QUAL   = 'QUAL';
    case TRA    = 'TRA';
    case COMPL  = 'COMPL';
    case AUTRES = 'AUTRES';

    public function label(): string
    {
        return match ($this) {
            self::PRE    => 'Préparatoire',
            self::FOR    => 'Formation',
            self::QUAL   => 'Qualification',
            self::TRA    => 'Transition',
            self::COMPL  => 'Complémentaire',
            self::AUTRES => 'Autres',
        };
    }
}
