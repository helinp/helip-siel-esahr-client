<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum RaisonOrdreDiEnum: int
{
    case PAS_ATTESTATION               = 1;
    case ATTESTATION_NON_VALABLE      = 2;
    case ABANDON                       = 3;
    case ATTESTATION_ECHUE            = 4;
    case PAS_COMPOSITION_MENAGE       = 5;
    case PAS_CHEF_MENAGE              = 6;
    case PAS_COMPO_ET_PAS_CHEF        = 7;
    case PAS_FICHE_INSCRIPTION        = 8;
    case NON_REPRIS_K0                = 9;
    case ETABLISSEMENT_NON_RECONNU    = 10;
    case AUTRES                       = 11;

    public function label(): string
    {
        return match ($this) {
            self::PAS_ATTESTATION            => 'Pas d’attestation',
            self::ATTESTATION_NON_VALABLE    => 'Attestation non valable',
            self::ABANDON                    => 'Abandon',
            self::ATTESTATION_ECHUE          => 'Attestation échue',
            self::PAS_COMPOSITION_MENAGE     => 'Pas de composition de ménage',
            self::PAS_CHEF_MENAGE            => 'Pas de mention "chef de ménage"',
            self::PAS_COMPO_ET_PAS_CHEF      => 'Pas de composition et pas "chef ménage"',
            self::PAS_FICHE_INSCRIPTION      => 'Pas de fiche d’inscription',
            self::NON_REPRIS_K0              => 'Élève non repris sur la K0',
            self::ETABLISSEMENT_NON_RECONNU  => 'Établissement non reconnu',
            self::AUTRES                     => 'Autres',
        };
    }
}
