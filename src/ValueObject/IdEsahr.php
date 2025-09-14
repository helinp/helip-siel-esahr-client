<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use InvalidArgumentException;

final class IdEsahr extends AbstractScalarValueObject
{
    /**
     * Identifiant ESAHR, format attendu :
     * - 1 à 10 chiffres suivis d’un tiret et de 1 ou 2 chiffres
     *
     * Exemples valides :
     * - 1-01
     * - 123456-00
     * - 1234567890-99
     * - 66058-1
     */
    protected function validate(string $value): void
    {
        if (!preg_match('/^[0-9]{1,10}-[0-9]{1,2}$/', $value)) {
            throw new InvalidArgumentException("IdEsahr invalide : '$value'");
        }

        // Vérifie la clé de contrôle
        [$num, $key] = explode('-', $value);
        $expected    = self::calculateCheckDigit((int) $num);

        if ((int) $key !== $expected) {
            throw new InvalidArgumentException(
                "Clé de contrôle invalide pour '$value'. Attendu : $expected"
            );
        }
    }

    /**
     * Calcule la clé de contrôle ESAHR.
     *
     * Règle déduite :
     *   clé = (deux derniers chiffres du numéro + 40) mod 97
     */
    public static function calculateCheckDigit(int $num): int
    {
        return $num % 97;
    }
}
