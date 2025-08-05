<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Enum\SuccessFlagEnum;

final class IndicatorNA extends AbstractEnumCodeValueObject
{
    protected static function getEnumClass(): string
    {
        return SuccessFlagEnum::class;
    }
}
