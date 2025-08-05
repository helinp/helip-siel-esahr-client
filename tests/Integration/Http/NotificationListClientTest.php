<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsRequestDto;
use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsMultipleResponseDto;
use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsResponseDto;
use Helip\SielEsahrClient\Http\Client\NotificationListClient;
use Helip\SielEsahrClient\Enum\NotificationCodeEnum;
use Helip\SielEsahrClient\Enum\NotificationMessageTypeEnum;
use Helip\SielEsahrClient\Exception\EsahrApiException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;

final class NotificationListClientTest extends AbstractEsahrClient
{
    private NotificationListClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new NotificationListClient($this->httpClient);
    }

    public function testListReturnsStructurallyValidResponse(): void
    {
        $accessToken = $this->getAccessToken();

        $request = new NotificationDetailsRequestDto(
            idEtab: 593,
            dateFrom: new DateTimeImmutable('-2 months')
        );

        try {
            $result = $this->client->list($accessToken, $request);

            $this->assertInstanceOf(NotificationDetailsMultipleResponseDto::class, $result);
            $this->assertNotEmpty($result->groups);

            foreach ($result->groups as $group) {
                $this->assertIsArray($group);
                $this->assertArrayHasKey('notifications', $group);
                $this->assertArrayHasKey('total', $group);
                $this->assertIsInt($group['total']);

                foreach ($group['notifications'] as $notification) {
                    $this->assertInstanceOf(NotificationDetailsResponseDto::class, $notification);
                    $this->assertIsInt($notification->notificationId);
                    $this->assertInstanceOf(IdEsahr::class, $notification->idEsahr);
                    $this->assertInstanceOf(DateTimeImmutable::class, $notification->notificationDt);
                    $this->assertInstanceOf(NotificationCodeEnum::class, $notification->notificationCode);
                    $this->assertInstanceOf(NotificationMessageTypeEnum::class, $notification->notificationMsgType);
                    $this->assertIsString($notification->notificationMsg);
                }
            }
        } catch (EsahrApiException $e) {
            $this->markTestIncomplete('Aucune notification retournée par l’API. Impossible de tester la validité structurelle.');
        }
    }


    public function testListThrowsExceptionWhenNoNotificationFound(): void
    {
        $this->expectException(EsahrApiException::class);
        $this->expectExceptionMessage('No notification found for etabId : 593');

        $accessToken = $this->getAccessToken();

        $request = new NotificationDetailsRequestDto(
            idEtab: 593,
            dateFrom: new DateTimeImmutable('2020-01-01')
        );

        $this->client->list($accessToken, $request);
    }
}
