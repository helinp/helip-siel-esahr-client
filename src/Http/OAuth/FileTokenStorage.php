<?php

namespace Helip\SielEsahrClient\Http\OAuth;

use DateTimeImmutable;

/**
 * Stockage des tokens d'authentification dans un fichier.
 *
 * ⚠️ Cette implémentation sauvegarde le jeton en clair dans un fichier local.
 * Elle est proposée comme exemple de base.
 * Pour un usage en production, il est recommandé d’implémenter votre propre
 * TokenStorageInterface
 */
final class FileTokenStorage implements TokenStorageInterface
{
    public function __construct(
        private string $path
    ) {
    }

    public function save(string $token, DateTimeImmutable $expiresAt): void
    {
        $data = json_encode([
            'token'     => $token,
            'expiresAt' => $expiresAt->getTimestamp(),
        ], JSON_THROW_ON_ERROR);

        file_put_contents($this->path, $data, LOCK_EX);
    }

    public function load(): ?array
    {
        if (!is_file($this->path)) {
            return null;
        }

        $payload = file_get_contents($this->path);
        if ($payload === false) {
            return null;
        }

        $decodedData = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);

        if (!isset($decodedData['token'], $decodedData['expiresAt'])) {
            return null;
        }

        return [
            'token'     => $decodedData['token'],
            'expiresAt' => (new DateTimeImmutable())->setTimestamp((int) $decodedData['expiresAt']),
        ];
    }
}
