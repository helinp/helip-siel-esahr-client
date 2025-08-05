<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CommuneSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;

/**
 * Doc: 4.1
 */
final readonly class CommuneSearchResponseDto extends AbstractResponseDto
{
    /**
     * @param CommuneSearchItemResponseDto[] $items
     */
    public function __construct(
        public array $items,
        public int $total
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        $items = [];
        foreach ($data['items'] as $item) {
            $items[] = CommuneSearchItemResponseDto::fromArray($item);
        }

        return new self(
            items: $items,
            total: $data['total']
        );
    }
}
