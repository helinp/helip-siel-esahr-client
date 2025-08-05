<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\NotificationDetails;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;

/**
 * Représente une **collection de groupes** de notifications.
 */
final readonly class NotificationDetailsMultipleResponseDto extends AbstractResponseDto
{
    /**
     * @param array<int, array{
     *     notifications: NotificationItemResponseDto[],
     *     total: int
     * }> $groups
     */
    public function __construct(
        public array $groups
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        $groups = [];

        foreach ($data as $groupData) {
            $notifications = array_map(
                static fn(array $item) => NotificationDetailsResponseDto::fromArray($item['notification']),
                $groupData['notifications'] ?? []
            );

            $groups[] = [
                'notifications' => $notifications,
                'total' => (int) ($groupData['total'] ?? 0),
            ];
        }

        return new self($groups);
    }
}

