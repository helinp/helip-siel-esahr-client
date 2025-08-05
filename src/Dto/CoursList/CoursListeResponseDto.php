<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CoursList;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;

/**
 * Lister les cours (4.7.1) / Réponse
 */
final readonly class CoursListeResponseDto extends AbstractResponseDto
{
    /**
     * @param CoursListeItemResponseDto[] $items
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
            $items[] = CoursListeItemResponseDto::fromArray($item);
        }

        return new self(
            items: $items,
            total: $data['total']
        );
    }
}
