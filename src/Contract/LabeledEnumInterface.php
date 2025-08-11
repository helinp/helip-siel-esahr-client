<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Contract;

use BackedEnum;

interface LabeledEnumInterface extends BackedEnum
{
    public function label(): string;
}
