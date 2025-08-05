<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Student;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 *  Multiple student response DTO
 */
final readonly class StudentMultipleResponseDto extends AbstractResponseDto
{
    /**
     * @param StudentResponseDto[] $items
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
            $items[] = StudentResponseDto::fromArray($item);
        }

        return new self(
            items: $items,
            total: $data['total']
        );
    }
}
