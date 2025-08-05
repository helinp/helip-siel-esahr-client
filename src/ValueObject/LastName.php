<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use InvalidArgumentException;

final class LastName extends AbstractScalarValueObject
{
    protected function validate(string $value): void
    {
        if (mb_strlen($value) > 80) {
            throw new InvalidArgumentException('LastName trop long : max 80 caractères.');
        }

        if ('' === trim($value)) {
            throw new InvalidArgumentException('LastName vide ou invalide.');
        }
    }
}
