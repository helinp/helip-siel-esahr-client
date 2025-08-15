<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsRequestDto;
use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsMultipleResponseDto;

/**
 * Doc: 4.2 Obtenir des notifications
 */
class NotificationListClient extends AbstractClient
{
    public function list(
        string $accessToken,
        NotificationDetailsRequestDto $request
    ): NotificationDetailsMultipleResponseDto {

        // Endpoint: notifications?idEtab=1&dateFrom=2023-01-01'
        $parameters = [
            'idEtab' => $request->idEtab,
            'dateFrom' => $request->dateFrom?->format('Y-m-d'),
        ];

        $parameters = array_filter($parameters, static fn ($value) => $value !== null);

        $data = $this->esahrHttpClient->get(
            'notifications' . '?' . http_build_query($parameters),
            $accessToken,
            $request->toArray()
        );

        return NotificationDetailsMultipleResponseDto::fromArray($data);
    }
}
