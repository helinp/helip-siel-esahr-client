<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Enum\GuardianCodeEnum;

final class GuardianCode extends AbstractEnumCodeValueObject
{
    protected static function getEnumClass(): string
    {
        return GuardianCodeEnum::class;
    }
}
