<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Utils;

final readonly class SielResponseUtils
{
    public static function isProblemDetails(array $data): bool
    {
        if (!isset($data['status'], $data['title'])) {
            return false;
        }

        if (!is_int($data['status']) && !ctype_digit((string) $data['status'])) {
            return false;
        }

        return !array_key_exists('inscription', $data);
    }

    public static function toProblemDetails(array $data): array
    {
        return [
            'status'   => (int)($data['status'] ?? 0),
            'title'    => (string)($data['title'] ?? ''),
            'detail'   => $data['detail']   ?? null,
            'type'     => $data['type']     ?? null,
            'instance' => $data['instance'] ?? null,
            'id'       => $data['id']       ?? null,
        ];
    }
}
