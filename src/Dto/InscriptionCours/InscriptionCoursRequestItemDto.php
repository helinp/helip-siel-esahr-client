<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCours;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursDataDto;
use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursSpecificityDto;
use Helip\SielEsahrClient\Dto\Common\RegulariteInputDto;

/**
 * Original type in doc: InscriptionCoursInput (see 4.8.1.3)
 *
 * @internal
 */
final readonly class InscriptionCoursRequestItemDto implements RequestDtoInterface
{
    public function __construct(
        public int $statusCode,
        public InscriptionCoursDataDto $inscriptionCoursData,
        public ?InscriptionCoursSpecificityDto $inscriptionCoursSpecificity,
        public ?RegulariteInputDto $regularity
    ) {
    }

    public function toArray(): array
    {
        return [
            'statusCode' => $this->statusCode,
            'inscriptionCoursData' => $this->inscriptionCoursData->toArray(),
            'inscriptionCoursSpecificity' => $this->inscriptionCoursSpecificity?->toArray(),
            'regularity' => $this->regularity?->toArray(),
        ];
    }
}
