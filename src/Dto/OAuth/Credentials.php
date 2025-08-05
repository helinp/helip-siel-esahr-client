<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\OAuth;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;

final readonly class Credentials implements RequestDtoInterface
{
    public function __construct(
        public string $clientId,
        public string $clientSecret,
        public string $username,
        public string $password,
        public string $namUrl = '',
        public string $scope = 'profile',
        public string $grantType = 'password',
    ) {
    }

    public function toArray(): array
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $this->username,
            'password' => $this->password,
            'scope' => $this->scope,
            'grant_type' => $this->grantType,
        ];
    }
}
