<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\ValidationSearch;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * @internal
 */
final readonly class ValidationSearchItemResponseDto extends AbstractResponseDto
{
    public function __construct(
        public string $validationType,
        public string $source,
        public DateTimeImmutable $dateValidation
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['validation']) || !is_array($data['validation'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "validation" key is missing or not an array.'
            );
        }

        $data = $data['validation'];
        return new self(
            validationType: $data['validationType'],
            source: $data['source'],
            dateValidation: new DateTimeImmutable($data['dateValidation'])
        );
    }
}
