<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCours;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**

 */
final readonly class InscriptionCoursMultipleResponseDto extends AbstractResponseDto
{
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
            $items[] = InscriptionCoursResponseDto::fromArray($item);
        }

        return new self(
            items: $items,
            total: $data['total']
        );
    }
}
