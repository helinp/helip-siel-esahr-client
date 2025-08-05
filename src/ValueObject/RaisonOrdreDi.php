<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Enum\RaisonOrdreDiEnum;

final class RaisonOrdreDi extends AbstractEnumCodeValueObject
{
    protected static function getEnumClass(): string
    {
        return RaisonOrdreDiEnum::class;
    }
}
