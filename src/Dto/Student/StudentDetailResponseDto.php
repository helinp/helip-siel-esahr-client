<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Student;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Common\PrivateAddressDto;

/**
 * @internal
 */
final readonly class StudentDetailResponseDto extends AbstractResponseDto
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
    }

    protected static function fromArrayInterne(array $data): static
    {
        return new self(
            ssin: $data['ssin'] ?? null,
            lastName: $data['lastName'] ?? null,
            firstName: $data['firstName'] ?? null,
            otherFirstNames: isset($data['otherFirstNames']) && is_array($data['otherFirstNames']) ? $data['otherFirstNames'] : null,
            genderCode: $data['genderCode'] ?? null,
            birth: isset($data['birth']) ? new DateTimeImmutable($data['birth']) : null,
            phoneNumber: $data['phoneNumber'] ?? null,
            gsmNumber: $data['gsmNumber'] ?? null,
            email: $data['email'] ?? null,
            encodePar: $data['encodePar'] ?? null,
            encodeParParam: $data['encodeParParam'] ?? null,
            privateAddress: isset($data['privateAddress']) && is_array($data['privateAddress'])
                ? PrivateAddressDto::fromArray($data['privateAddress'])
                : null,
            guardians: isset($data['guardians']) && is_array($data['guardians'])
                ? array_map(
                    fn (array $guardian) => GuardianDetailDto::fromArray(...),
                    $data['guardians']
                )
                : []
        );
    }
}
