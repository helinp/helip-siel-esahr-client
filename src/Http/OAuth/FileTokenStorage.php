<?php

namespace Helip\SielEsahrClient\Http\OAuth;

use DateTimeImmutable;
use JsonException;
use RuntimeException;
use Throwable;

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

        $dir = dirname($this->path);
        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new RuntimeException(sprintf('Impossible de créer le répertoire "%s"', $dir));
        }

        $tmp = tempnam($dir, 'siel_token_');
        if ($tmp === false) {
            throw new RuntimeException('Impossible de créer un fichier temporaire pour le token.');
        }

        // Écrit tout d’un bloc
        if (file_put_contents($tmp, $data, LOCK_EX) === false) {
            try {
                unlink($tmp);
            } catch (Throwable) {
                // Rien à faire
            }
            throw new RuntimeException('Échec d\'écriture du token.');
        }

        // Permissions restrictives (token en clair)
        try {
            chmod($dir, 0775);
        } catch (Throwable) {
            // Rien à faire
        }

        // Swap atomique
        if (!rename($tmp, $this->path)) {
            unlink($tmp);
            throw new RuntimeException(sprintf('Impossible de déplacer le token vers "%s".', $this->path));
        }
    }

    public function load(): ?array
    {
        if (!is_file($this->path)) {
            return null;
        }

        $payload = false;
        try {
            $payload = file_get_contents($this->path);
        } catch (Throwable) {
            // Rien à faire
        }
        if ($payload === false || $payload === '') {
            return null;
        }

        try {
            /** @var array{token:mixed,expiresAt:mixed} $decodedData */
            $decodedData = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return null; // Contenu corrompu/partiel
        }

        if (!is_string($decodedData['token'] ?? null) || !is_numeric($decodedData['expiresAt'] ?? null)) {
            return null;
        }

        $expiresAtTs = (int) $decodedData['expiresAt'];
        if ($expiresAtTs <= 0) {
            return null;
        }

        return [
            'token'     => $decodedData['token'],
            'expiresAt' => (new DateTimeImmutable())->setTimestamp($expiresAtTs),
        ];
    }
}
