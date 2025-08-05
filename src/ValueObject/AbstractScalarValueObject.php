<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use InvalidArgumentException;

abstract class AbstractScalarValueObject
{
    protected string $value;

    final public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    abstract protected function validate(string $value): void;

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
