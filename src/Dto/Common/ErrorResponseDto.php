<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\Common;

/**
 * Représente une erreur structurée renvoyée par l’API ESAHR.
 * Conforme au format "application/problem+json" (RFC 7807).
 */
final readonly class ErrorResponseDto
{
    /**
     * @param string|null $type     URI identifiant le type de problème
     * @param string|null $title    Résumé court et lisible du problème
     * @param int         $status   Code HTTP de la réponse (ex: 400, 403, 500)
     * @param string|null $detail   Détail lisible expliquant l’erreur
     * @param string|null $instance URI de la requête ou identifiant d’occurrence
     * @param mixed|null  $code     Code métier optionnel (ex: code interne ESAHR)
     */
    public function __construct(
        public ?string $type,
        public ?string $title,
        public int $status,
        public ?string $detail,
        public ?string $instance,
        public mixed $code = null,
    ) {
    }

    /**
     * Hydrate un objet d’erreur à partir d’un tableau brut (ex : réponse HTTP JSON)
     *
     * @param  array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'] ?? null,
            title: $data['title'] ?? null,
            status: $data['status'] ?? 0,
            detail: $data['detail'] ?? null,
            instance: $data['instance'] ?? null,
            code: $data['code'] ?? null,
        );
    }
}
