<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use InvalidArgumentException;

final class FirstName extends AbstractScalarValueObject
{
    protected function validate(string $value): void
    {
        if (mb_strlen($value) > 30) {
            throw new InvalidArgumentException('FirstName trop long : max 30 caractères.');
        }

        if ('' === trim($value)) {
            throw new InvalidArgumentException('FirstName vide ou invalide.');
        }
    }
}
