<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\SchoolPath;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**

 */
final readonly class SchoolPathRequestDto implements RequestDtoInterface
{
    public function __construct(
        public IdEsahr $idEsahr
    ) {
    }

    public function toArray(): array
    {
        return [
            'idEsahr' => $this->idEsahr->value(),
        ];
    }
}
