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
            ssin: $data['SSIN'] ?? null,
            lastName: $data['LastName'] ?? null,
            firstName: $data['FirstName'] ?? null,
            otherFirstNames: isset($data['OtherFirstNames']) && is_array($data['OtherFirstNames']) ? $data['OtherFirstNames'] : null,
            genderCode: $data['GenderCode'] ?? null,
            birth: isset($data['Birth']) ? new DateTimeImmutable($data['Birth']) : null,
            phoneNumber: $data['PhoneNumber'] ?? null,
            gsmNumber: $data['GsmNumber'] ?? null,
            email: $data['Mail'] ?? null,
            encodePar: $data['EncodePar'] ?? null,
            encodeParParam: $data['EcodeParParam'] ?? null,
            privateAddress: isset($data['PrivateAddress']) && is_array($data['PrivateAddress'])
                ? PrivateAddressDto::fromArray($data['PrivateAddress'])
                : null,
            guardians: isset($data['Guardians']) && is_array($data['Guardians'])
                ? array_map(
                    fn (array $guardian) => GuardianDetailDto::fromArray(...),
                    $data['Guardians']
                )
                : []
        );
    }

}
