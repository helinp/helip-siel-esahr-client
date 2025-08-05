<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Enum\StatusCodeEnum;

final class StatusCode extends AbstractEnumCodeValueObject
{
    /**
     * @return class-string<StatusCodeEnum>
     */
    protected static function getEnumClass(): string
    {
        return StatusCodeEnum::class;
    }
}
