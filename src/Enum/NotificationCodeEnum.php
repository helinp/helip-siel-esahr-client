<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

enum NotificationCodeEnum: string
{
    // ELEVE
    case ELEVE_GENRE       = '11';
    case ELEVE_NOM_PRENOM  = '12';
    case ELEVE_ADRESSE     = '13';
    case ELEVE_NATIONALITE = '14';
    case ELEVE_NISS        = '15';

    // REGUL
    case REGUL_ORDRE_DI         = '20';
    case REGUL_PAS_ORDRE_DI     = '21';
    case REGUL_REGULIER_DOM     = '22';
    case REGUL_NON_REGULIER_DOM = '23';

    // SUBV
    case SUBV_COMPTABILISE         = '30';
    case SUBV_NON_COMPTABILISE     = '31';
    case SUBV_SUBVENTIONNE_DOM     = '32';
    case SUBV_NON_SUBVENTIONNE_DOM = '33';

    public function label(): string
    {
        return match ($this) {
            // Élève
            self::ELEVE_GENRE       => 'Changement de genre',
            self::ELEVE_NOM_PRENOM  => 'Changement nom/prénom',
            self::ELEVE_ADRESSE     => 'Changement d’adresse',
            self::ELEVE_NATIONALITE => 'Changement de nationalité',
            self::ELEVE_NISS        => 'Changement de NISS',

            // Régularité
            self::REGUL_ORDRE_DI         => 'Élève en ordre du droit d’inscription [AAAA]',
            self::REGUL_PAS_ORDRE_DI     => 'Élève pas en ordre du droit d’inscription [AAAA]',
            self::REGUL_REGULIER_DOM     => 'Élève régulier [AAAA], [DOM], [TYPE_FILIERE]',
            self::REGUL_NON_REGULIER_DOM => 'Élève non régulier [AAAA], [DOM], [TYPE_FILIERE]',

            // Subvention
            self::SUBV_COMPTABILISE         => 'Élève comptabilisé [AAAA]',
            self::SUBV_NON_COMPTABILISE     => 'Élève non comptabilisé [AAAA]',
            self::SUBV_SUBVENTIONNE_DOM     => 'Élève subventionné [AAAA], [DOM], [TYPE_FILIERE]',
            self::SUBV_NON_SUBVENTIONNE_DOM => 'Élève non subventionné [AAAA], [DOM], [TYPE_FILIERE]',
        };
    }
}
