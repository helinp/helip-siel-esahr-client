<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use InvalidArgumentException;

final class PhoneNumber extends AbstractScalarValueObject
{
    protected function validate(string $value): void
    {
        $len = mb_strlen($value);

        if ($len < 1 || $len > 15) {
            throw new InvalidArgumentException('PhoneNumber doit faire entre 1 et 15 caractères.');
        }

        if (!preg_match('/^\+?[0-9 ]+$/', $value)) {
            throw new InvalidArgumentException("PhoneNumber invalide : '$value'");
        }
    }
}
