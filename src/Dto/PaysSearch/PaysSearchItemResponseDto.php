<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\PaysSearch;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * Doc: 4.11
 *
 * @internal
 */
final readonly class PaysSearchItemResponseDto extends AbstractResponseDto
{
    /**
     * @param string            $codeOnss  Code ONSS
     * @param DateTimeImmutable $dateStart Date de début
     * @param DateTimeImmutable $dateEnd   Date de fin
     * @param string            $codeIso   Code ISO
     * @param string            $codeIso3  Code ISO 3
     * @param string            $name      Nom
     * @param string            $longName  Nom long
     */
    public function __construct(
        public string $codeOnss,
        public DateTimeImmutable $dateStart,
        public DateTimeImmutable $dateEnd,
        public string $codeIso,
        public string $codeIso3,
        public string $name,
        public string $longName,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        if (!isset($data['country']) || !is_array($data['country'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: "country" key is missing or not an array.',
                0,
                null,
                $data
            );
        }

        $data = $data['country'];

        return new self(
            codeOnss: $data['codeOnss'],
            dateStart: new DateTimeImmutable($data['dateStart']),
            dateEnd: new DateTimeImmutable($data['dateEnd']),
            codeIso: $data['codeIso'],
            codeIso3: $data['codeIso3'],
            name: $data['name'],
            longName: $data['longName'],
        );
    }
}
