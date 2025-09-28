<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Contract;

abstract readonly class AbstractResponseDto implements ResponseDtoInterface
{
    public static function fromArray(array $data): static
    {
        return static::fromArrayInterne($data);
    }

    public function toArray(): array
    {
        return (array) $this;
    }

    abstract protected static function fromArrayInterne(array $data): static;
}
