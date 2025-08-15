<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Enum\IndicatorNAEnum;

final class IndicatorNA extends AbstractEnumCodeValueObject
{
    protected static function getEnumClass(): string
    {
        return IndicatorNAEnum::class;
    }
}
