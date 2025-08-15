<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCoursSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;

/**
 * Représente un ensemble de résultats d’inscriptions cours (4.8).
 */
final readonly class InscriptionCoursSearchMultipleResponseDto extends AbstractResponseDto
{
    /**
     * @param InscriptionCoursSearchResponseDto[] $items
     */
    public function __construct(
        public array $items,
        public int $total
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        $items = array_map(
            static fn (array $entry) => InscriptionCoursSearchResponseDto::fromArray($entry),
            $data['items'] ?? []
        );

        return new self(
            items: $items,
            total: (int) $data['total']
        );
    }
}
