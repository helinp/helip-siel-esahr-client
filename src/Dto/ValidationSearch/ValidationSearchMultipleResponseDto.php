<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\ValidationSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;

/**
 *  Multiple student response DTO
 */
final readonly class ValidationSearchMultipleResponseDto extends AbstractResponseDto
{
    public function __construct(
        public array $items,
        public int $total
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        $items = [];
        foreach ($data['items'] as $item) {
            $items[] = ValidationSearchItemResponseDto::fromArray($item);
        }

        return new self(
            items: $items,
            total: $data['total']
        );
    }
}
