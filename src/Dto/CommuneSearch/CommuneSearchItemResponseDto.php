<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CommuneSearch;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * Doc: 4.1
 *
 * @internal
 */
final readonly class CommuneSearchItemResponseDto extends AbstractResponseDto
{
    public function __construct(
        public string $codeIns,
        public string $nameCommune,
        public string $nameLocality,
        public string $postalCode,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['commune']) || !is_array($data['commune'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "commune" key is missing or not an array.'
            );
        }
        $data = $data['commune'];

        return new self(
            codeIns: $data['codeIns'],
            nameCommune: $data['nameCommune'],
            nameLocality: $data['nameLocality'],
            postalCode: $data['postalCode'],
        );
    }
}
