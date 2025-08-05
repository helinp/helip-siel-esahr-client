<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\StudentSearch;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\ValueObject\BirthDate;
use Helip\SielEsahrClient\ValueObject\FirstName;
use Helip\SielEsahrClient\ValueObject\GenderCode;
use Helip\SielEsahrClient\ValueObject\LastName;
use Helip\SielEsahrClient\ValueObject\Ssin;

/**
 * Rechercher un élève par combinaison (4.4.2)
 */
final readonly class StudentSearchCombinaisonRequestDto implements RequestDtoInterface
{
    public function __construct(
        public Ssin $ssin,
        public LastName $lastName,
        public ?FirstName $firstName = null,
        public ?BirthDate $birthDate = null,
        public ?GenderCode $genderCode = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'ssin'       => $this->ssin->value(),
            'lastName'   => $this->lastName->value(),
            'firstName'  => $this->firstName?->value(),
            'birthDate'  => $this->birthDate?->value(),
            'genderCode' => $this->genderCode?->value(),
        ];
    }
}
