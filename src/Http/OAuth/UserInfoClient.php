<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\OAuth;

use Helip\SielEsahrClient\Dto\OAuth\UserInfoRequestDto as OAuthUserInfoRequestDto;
use Helip\SielEsahrClient\Dto\OAuth\UserInfoResponseDto;
use Helip\SielEsahrClient\Http\Transport\NamHttpClient;

final class UserInfoClient
{
    private readonly NamHttpClient $namHttpClient;

    public function __construct(NamHttpClient $namHttpClient)
    {
        $this->namHttpClient = $namHttpClient;
    }

    public function getUserInfo(
        string $accessToken,
        OAuthUserInfoRequestDto $userInfoRequestDto
    ): UserInfoResponseDto {

        $data = $this->namHttpClient->get(
            'userinfo',
            $accessToken,
            $userInfoRequestDto->toArray()
        );

        return UserInfoResponseDto::fromArray($data);
    }
}
