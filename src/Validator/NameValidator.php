<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Validator;

use InvalidArgumentException;

/**
 * Fournit une méthode pour valider les noms et prénoms
 * selon les règles ESAHR :
 * - lettres uniquement
 * - séparateurs autorisés : espace, tiret (-), virgule (,) et apostrophe (')
 */
final class NameValidator
{
    public static function assertValid(string $value, string $field): void
    {
        if (!preg_match('/^[\p{L}\s,\-\'’]+$/u', $value)) {
            throw new InvalidArgumentException(
                "Invalid characters in $field. Only letters and separators are allowed: '-', ',', space, and apostrophe."
            );
        }
    }
}
