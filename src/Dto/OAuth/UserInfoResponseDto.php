<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\OAuth;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;

final readonly class UserInfoResponseDto extends AbstractResponseDto
{
    public function __construct(
        public string $sub,
        public array $roles,
        public string $groups,
        public string $nickname,
        public string $preferredUsername,
        public string $givenName,
        public string $familyName,
        public string $username,
        public ?string $name = null,
        public array $claims = [],
        public ?string $employeeNumber = null,
        public ?string $population = null,
        public ?string $cfwbULoginName = null,
        public ?string $email = null,
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        return new self(
            sub: $data['sub'],
            roles: $data['role'] ?? [],
            groups: $data['Groups'] ?? '',
            nickname: $data['nickname'] ?? '',
            name: $data['name'] ?? '',
            claims: $data['claims'] ?? [],
            preferredUsername: $data['preferred_username'] ?? '',
            givenName: $data['given_name'] ?? '',
            familyName: $data['family_name'] ?? '',
            employeeNumber: $data['employeeNumber'] ?? '',
            username: $data['username'] ?? '',
            population: $data['population'] ?? '',
            cfwbULoginName: $data['cfwbULoginName'] ?? '',
            email: $data['email'] ?? '',
        );
    }
}
