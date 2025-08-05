<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Contract;

interface ResponseDtoInterface
{
    public static function fromArray(array $data): static;
}
