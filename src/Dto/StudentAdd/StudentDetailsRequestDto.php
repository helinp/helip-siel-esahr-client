<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\StudentAdd;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\RequestDtoInterface;
use Helip\SielEsahrClient\Dto\Common\PrivateAddressDto;
use Helip\SielEsahrClient\Dto\Student\GuardianDetailDto;
use Helip\SielEsahrClient\Validator\NameValidator;

/**
 * Sauvegarder un élève 4.3.1 / Modifier un élève 4.3.2
 *
 * @todo: Gérer le cas où le champ `birth` ne contient que l'année de naissance.
 */
final readonly class StudentDetailsRequestDto implements RequestDtoInterface
{
    public function __construct(
        public ?string $ssin,
        public ?string $lastName,
        public ?string $firstName,
        public ?array $otherFirstNames,
        public ?string $genderCode,
        public ?DateTimeImmutable $birth,
        public ?string $phoneNumber,
        public ?string $gsmNumber,
        public ?string $email,
        public ?string $encodePar,
        public ?string $encodeParParam,
        public ?PrivateAddressDto $privateAddress,
        /**
         * @var GuardianDetailDto[]
         */
        public ?array $guardians = [],
    ) {
        NameValidator::assertValid($lastName, 'lastName');
        NameValidator::assertValid($firstName, 'firstName');

        if ($otherFirstNames !== null) {
            foreach ($otherFirstNames as $i => $name) {
                NameValidator::assertValid($name, "otherFirstNames[$i]");
            }
        }
    }

    public function toArray(): array
    {
        return [
            'ssin'            => $this->ssin,
            'lastName'        => $this->lastName,
            'firstName'       => $this->firstName,
            'otherFirstNames' => $this->otherFirstNames,
            'genderCode'      => $this->genderCode,
            'birth'           => $this->birth?->format('Y-m-d'),
            'phoneNumber'     => $this->phoneNumber,
            'gsmNumber'       => $this->gsmNumber,
            'email'           => $this->email,
            'encodePar'       => $this->encodePar,
            'encodeParParam'  => $this->encodeParParam,
            'privateAddress'  => $this->privateAddress?->toArray(),
            'guardians'       => array_map(
                fn (GuardianDetailDto $g) => $g->toArray(),
                $this->guardians ?? []
            ),
        ];
    }
}
