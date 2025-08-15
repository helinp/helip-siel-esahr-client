<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\OAuth;

use Helip\SielEsahrClient\Contract\RequestDtoInterface;

/**
 * Doc: 3.2 UserInfo
 */
final readonly class UserInfoRequestDto implements RequestDtoInterface
{
    public function __construct(
        public string $clientId,
        public string $clientSecret,
        public string $token
    ) {
    }

    public function toArray(): array
    {
        return [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'token'         => $this->token,
        ];
    }
}
