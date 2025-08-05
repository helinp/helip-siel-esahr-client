<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use InvalidArgumentException;

final class IdEsahr extends AbstractScalarValueObject
{
    /**
     * Identifiant ESAHR, format attendu :
     * - 1 à 10 chiffres suivis d’un tiret et de 2 chiffres
     *
     * Exemples valides :
     * - 1-01
     * - 123456-00
     * - 1234567890-99
     */
    protected function validate(string $value): void
    {
        if (!preg_match('/^[0-9]{1,10}-[0-9]{2}$/', $value)) {
            throw new InvalidArgumentException("IdEsahr invalide : '$value'");
        }
    }
}
