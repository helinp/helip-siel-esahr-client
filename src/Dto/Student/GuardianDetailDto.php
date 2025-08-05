<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Student;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Dto\Common\PrivateAddressDto;
use Helip\SielEsahrClient\Validator\NameValidator;
use Helip\SielEsahrClient\ValueObject\GuardianCode;

final readonly class GuardianDetailDto extends AbstractResponseDto
{
    public function __construct(
        public ?string $lastName,
        public ?string $firstName,
        public ?GuardianCode $guardianCode,
        public ?string $phoneNumber,
        public ?string $gsmNumber,
        public ?string $email,
        public ?PrivateAddressDto $privateAddress,
        public ?bool $sameAddressFlag,
    ) {
        NameValidator::assertValid($lastName, 'lastName');
        NameValidator::assertValid($firstName, 'firstName');
    }

    protected static function fromArrayInterne(array $data): static
    {
        return new self(
            lastName: $data['lastName'] ?? null,
            firstName: $data['firstName'] ?? null,
            guardianCode: isset($data['guardianCode']) && is_string($data['guardianCode'])
                ? (new GuardianCode($data['guardianCode']))
                : null,
            phoneNumber: $data['phoneNumber'] ?? null,
            gsmNumber: $data['gsmNumber'] ?? null,
            email: $data['mail'] ?? null,
            privateAddress: isset($data['privateAddress']) && is_array($data['privateAddress'])
                ? PrivateAddressDto::fromArray($data['privateAddress'])
                : null,
            sameAddressFlag: $data['sameAddressFlag'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'lastName' => $this->lastName,
            'firstName' => $this->firstName,
            'guardianCode' => $this->guardianCode->value(),
            'phoneNumber' => $this->phoneNumber,
            'gsmNumber' => $this->gsmNumber,
            'email' => $this->email,
            'privateAddress' => $this->privateAddress?->toArray(),
            'sameAddressFlag' => $this->sameAddressFlag,
        ];
    }
}
