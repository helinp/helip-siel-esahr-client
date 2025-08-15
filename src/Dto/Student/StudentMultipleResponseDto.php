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
                'Invalid response format: "items" key is missing or not an array.'
            );
        }

        $items = [];
        foreach ($data['items'] as $item) {
            // Chaque élément de "items" contient directement un objet "students"
            if (!isset($item['students']) || !is_array($item['students'])) {
                throw new EsahrApiResponseException(
                    'Invalid response format: "students" key is missing or not an array in item.'
                );
            }

            $items[] = StudentDetailsResponseDto::fromArray($item['students']);
        }

        return new self(
            items: $items,
            total: $data['total']
        );
    }
}
