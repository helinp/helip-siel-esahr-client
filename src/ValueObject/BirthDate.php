<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use InvalidArgumentException;

/**
 * Date de naissance (ESAHR v1.5.18), formats valides :
 * - Année seule : 1970
 * - Date complète : 1951-8-2, 1951-08-02
 */
final class BirthDate extends AbstractScalarValueObject
{
    protected function validate(string $value): void
    {
        if (!preg_match('/^[1-2][0-9]{3}(-[0-1]?[0-9]-[0-3]?[0-9])?$/', $value)) {
            throw new InvalidArgumentException("Invalid BirthDate format: '$value'");
        }
    }

    public function format(): string
    {
        return $this->value;
    }
}
