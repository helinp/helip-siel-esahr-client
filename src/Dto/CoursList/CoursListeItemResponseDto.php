<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\CoursList;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * @internal
 */
final readonly class CoursListeItemResponseDto extends AbstractResponseDto
{
    public function __construct(
        public string $codeDomaine,
        public string $codeFiliere,
        public int $codeCours,
        public string $descrCourte,
        public string $descrLongue,
        public string $anneeList,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        if (!isset($data['codeCours']) || !is_array($data['codeCours'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "codeCours" key is missing or not an array.'
            );
        }

        $data = $data['codeCours'];

        return new self(
            codeDomaine: $data['codeDomaine'],
            codeFiliere: $data['codeFiliere'],
            codeCours: (int) $data['codeCours'],
            descrCourte: $data['descrCourte'],
            descrLongue: $data['descrLongue'],
            anneeList: $data['anneeList'],
        );
    }
}
