<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Enum\GenderCodeEnum;

final class GenderCode extends AbstractEnumCodeValueObject
{
    protected static function getEnumClass(): string
    {
        return GenderCodeEnum::class;
    }
}
