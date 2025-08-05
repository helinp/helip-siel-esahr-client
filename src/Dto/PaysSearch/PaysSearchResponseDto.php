<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\PaysSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * Doc: 4.11
 */
final readonly class PaysSearchResponseDto extends AbstractResponseDto
{
    /**
     * @param PaysSearchItemResponseDto[] $items
     */
    public function __construct(
        public array $items,
        public int $total
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['items']) || !is_array($data['items'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "items" key is missing or not an array.',
                0,
                null,
                $data
            );
        }

        $items = [];
        foreach ($data['items'] as $item) {
            $items[] = PaysSearchItemResponseDto::fromArray($item);
        }

        return new self(
            items: $items,
            total: $data['total']
        );
    }
}
