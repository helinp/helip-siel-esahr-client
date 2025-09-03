<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\OAuth;

use DateTimeImmutable;

interface TokenStorageInterface
{
    /**
     * Sauvegarde un access token et son expiration.
     */
    public function save(string $token, DateTimeImmutable $expiresAt): void;

    /**
     * Retourne un token et son expiration, ou null si absent.
     *
     * @return array{token: string, expiresAt: DateTimeImmutable}|null
     */
    public function load(): ?array;
}
