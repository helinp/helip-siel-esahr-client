<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Enum\IndicatorOnHoldEnum;

final class IndicatorOnHold extends AbstractEnumCodeValueObject
{
    protected static function getEnumClass(): string
    {
        return IndicatorOnHoldEnum::class;
    }
}
