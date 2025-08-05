<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CodeExemptionSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * Doc: 4.2
 *
 * @internal
 */
final readonly class CodeExemptionSearchItemResponseDto extends AbstractResponseDto
{
    public function __construct(
        public string $code,
        public string $text,
        public ?string $longText
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['exemption']) || !is_array($data['exemption'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "exemption" key is missing or not an array.',
                0,
                null,
                $data
            );
        }

        $data = $data['exemption'];

        return new self(
            code: $data['code'],
            text: $data['text'],
            longText: $data['longText']
        );
    }
}
