<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsRequestDto;
use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsMultipleResponseDto;

/**
 * Doc: 4.2 Obtenir des notifications
 */
final class NotificationListClient extends AbstractClient
{
    public function list(
        string $accessToken,
        NotificationDetailsRequestDto $request
    ): NotificationDetailsMultipleResponseDto {
        $data = $this->esahrHttpClient->get(
            'notifications',
            $accessToken,
            $request->toArray()
        );

        return NotificationDetailsMultipleResponseDto::fromArray($data);
    }
}
