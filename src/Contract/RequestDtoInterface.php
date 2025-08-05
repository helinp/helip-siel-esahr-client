<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Contract;

interface RequestDtoInterface
{
    public function toArray(): array;
}
