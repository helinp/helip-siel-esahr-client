<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\NISS\NISS;
use InvalidArgumentException;

final class Ssin extends AbstractScalarValueObject
{
    /**
     * Accepte :
     * - 01020312345
     * - 010203-123-45
     * - 010203123-45
     *
     * (Page 69 Doc ESAHR, v1.5.18)
     */
    protected function validate(string $value): void
    {
        if (!preg_match('/^[0-9]{6}(\-)?[0-9]{3}(\-)?[0-9]{2}$/', $value)) {
            throw new InvalidArgumentException("SSIN invalide : format incorrect");
        }

        try {
            new NISS($value);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException("SSIN invalide : " . $e->getMessage());
        }
    }
}
