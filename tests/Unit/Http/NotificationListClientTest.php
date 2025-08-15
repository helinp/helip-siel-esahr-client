<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsMultipleResponseDto;
use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsRequestDto;
use Helip\SielEsahrClient\Dto\NotificationDetails\NotificationDetailsResponseDto;
use Helip\SielEsahrClient\Http\Client\NotificationListClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(NotificationListClient::class)]
final class NotificationListClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): NotificationDetailsRequestDto
    {
        return new NotificationDetailsRequestDto(
            idEtab: 1,
            dateFrom: new DateTimeImmutable('2023-01-01')
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'notification_list_response.json',
            clientClassName: NotificationListClient::class,
            endpoint: 'notifications?idEtab=1&dateFrom=2023-01-01',
        );
    }

    #[CoversMethod(NotificationListClient::class, 'list')]
    public function testListResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'list',
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(NotificationDetailsMultipleResponseDto::class, $response);
        $this->assertCount(2, $response->groups);
        $this->assertInstanceOf(NotificationDetailsResponseDto::class, $response->groups[0]['notifications'][0]);
    }
}
