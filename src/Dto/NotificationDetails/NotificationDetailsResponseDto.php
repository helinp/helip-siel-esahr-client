<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\NotificationDetails;

use DateTimeImmutable;
use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Enum\NotificationCodeEnum;
use Helip\SielEsahrClient\Enum\NotificationMessageTypeEnum;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final readonly class NotificationDetailsResponseDto extends AbstractResponseDto
{
    public function __construct(
        public int $notificationId,
        public IdEsahr $idEsahr,
        public DateTimeImmutable $notificationDt,
        public NotificationCodeEnum $notificationCode,
        public NotificationMessageTypeEnum $notificationMsgType,
        public string $notificationMsg
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {

        foreach (['notificationId', 'idEsahr', 'notificationDt', 'notificationCode', 'notificationMsgType', 'notificationMsg'] as $key) {
            if (!isset($data[$key])) {
                throw new EsahrApiResponseException(
                    sprintf('Invalid response format: "%s" key is missing.', $key),
                    0,
                    null,
                    $data
                );
            }
        }

        return new self(
            notificationId: (int) $data['notificationId'],
            idEsahr: new IdEsahr($data['idEsahr']),
            notificationDt: new DateTimeImmutable($data['notificationDt']),
            notificationCode: NotificationCodeEnum::from($data['notificationCode']),
            notificationMsgType: NotificationMessageTypeEnum::from($data['notificationMsgType']),
            notificationMsg: $data['notificationMsg']
        );
    }
}
