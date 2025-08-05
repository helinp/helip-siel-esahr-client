<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Contract;

interface EnumCodeValueObjectInterface
{
    public function value(): string|int;
    public function label(): string;
    public static function choices(): array;
    public function __toString(): string;
}
