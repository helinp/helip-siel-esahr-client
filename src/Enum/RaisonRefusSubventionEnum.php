<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum RaisonRefusSubventionEnum: int
{
    case ABANDON                           = 1;
    case PRESENCE_INSUFFISANTE             = 2;
    case PAS_DROIT_INSCRIPTION             = 3;
    case NON_REPRIS_K1                     = 4;
    case AGE_MINIMUM_NON_ATTEINT           = 5;
    case PERIODES_COURS_INSUFFISANTES      = 6;
    case UN_SEUL_COURS_COMPLEMENTAIRE      = 7;
    case DEUX_COURS_COMPLEMENTAIRES        = 8;
    case DOUBLE_SUBVENTION                 = 9;
    case FICHE_INSCRIPTION_MANQUANTE       = 10;
    case COURS_DEJA_SUIVI_AILLEURS         = 11;
    case PAS_FORMATION_MUSICALE            = 12;
    case COURS_ORGANISE_INSUFFISANT        = 13;
    case REGISTRE_INCOMPLET                = 14;
    case PAS_MUSIQUE_CHAMBRE               = 15;
    case FORMATION_INSTRUMENT_NON_TERMINEE = 16;
    case PERIODES_TRANSITION_INSUFFISANTES = 17;
    case COURS_NON_RECONNU                 = 18;
    case ECOLE_NON_RECONNUE                = 19;
    case DUREE_ETUDE_DEPASSEE              = 20;
    case AUTRE                             = 21;

    public function label(): string
    {
        return match ($this) {
            self::ABANDON                           => 'Abandon',
            self::PRESENCE_INSUFFISANTE             => 'Présences insuffisantes',
            self::PAS_DROIT_INSCRIPTION             => "Pas en ordre de droit d'inscription",
            self::NON_REPRIS_K1                     => "N'est pas repris sur la K1",
            self::AGE_MINIMUM_NON_ATTEINT           => "Âge minimal non atteint",
            self::PERIODES_COURS_INSUFFISANTES      => "Périodes de cours insuffisantes",
            self::UN_SEUL_COURS_COMPLEMENTAIRE      => "Un seul cours complémentaire",
            self::DEUX_COURS_COMPLEMENTAIRES        => "Deux cours complémentaires",
            self::DOUBLE_SUBVENTION                 => "Double subvention",
            self::FICHE_INSCRIPTION_MANQUANTE       => "Fiche d'inscription manquante",
            self::COURS_DEJA_SUIVI_AILLEURS         => "Cours déjà suivi ailleurs",
            self::PAS_FORMATION_MUSICALE            => "Pas de formation musicale",
            self::COURS_ORGANISE_INSUFFISANT        => "Cours organisé avec périodes insuffisantes",
            self::REGISTRE_INCOMPLET                => "Registre incomplet",
            self::PAS_MUSIQUE_CHAMBRE               => "Pas de musique de chambre instrumentale",
            self::FORMATION_INSTRUMENT_NON_TERMINEE => "Formation instrumentale non terminée",
            self::PERIODES_TRANSITION_INSUFFISANTES => "Périodes de transition insuffisantes",
            self::COURS_NON_RECONNU                 => "Cours non reconnu",
            self::ECOLE_NON_RECONNUE                => "École non reconnue",
            self::DUREE_ETUDE_DEPASSEE              => "Durée d’étude dépassée",
            self::AUTRE                             => "Autre",
        };
    }
}
