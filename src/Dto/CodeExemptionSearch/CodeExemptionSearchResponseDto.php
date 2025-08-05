<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CodeExemptionSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;

/**
 * Codes d'exemption
 * Doc: 4.2
 * Pas de payload ni paramètres get
 */
final readonly class CodeExemptionSearchResponseDto extends AbstractResponseDto
{
    /**
     * @param CodeExemptionSearchItemResponseDto[] $items
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
            $items[] = CodeExemptionSearchItemResponseDto::fromArray($item);
        }

        return new self(
            items: $items,
            total: $data['total']
        );
    }
}
