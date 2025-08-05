<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Contract;

use Helip\SielEsahrClient\Contract\ResponseDtoInterface;
use InvalidArgumentException;
use Throwable;

abstract readonly class AbstractResponseDto implements ResponseDtoInterface
{
    public static function fromArray(array $data): static
    {
        try {
            return static::fromArrayInterne($data);
        } catch (Throwable $e) {
            throw new InvalidArgumentException(
                sprintf("Failed to hydrate %s: %s", static::class, $e->getMessage()),
                previous: $e
            );
        }
    }

    abstract protected static function fromArrayInterne(array $data): static;
}
