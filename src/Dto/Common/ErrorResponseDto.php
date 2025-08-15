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
     * @param int         $status   Code HTTP (ex: 400, 403, 500)
     * @param string|null $detail   Détail lisible expliquant l’erreur
     * @param string|null $instance URI de la requête ou identifiant d’occurrence
     * @param array<int, array<string, mixed>> $invalidParams Liste d'items invalid-params (RFC 7807 extension)
     */
    public function __construct(
        public ?string $type,
        public ?string $title,
        public int $status,
        public ?string $detail,
        public ?string $instance,
        public array $invalidParams = []
    ) {}

    /**
     * Hydrate un objet d’erreur à partir d’un tableau brut (ex : réponse HTTP JSON).
     */
    public static function fromArray(array $data): self
    {
        // Normalisation de invalidParams : accepte un objet unique ou une liste
        $invalidParams = [];
        if (isset($data['invalidParams'])) {
            $raw = $data['invalidParams'];
            if (is_array($raw)) {
                if ($raw !== [] && array_is_list($raw)) {
                    $invalidParams = $raw;
                } else {
                    // Objet unique fourni
                    $invalidParams = [$raw];
                }
            }
        }

        return new self(
            type: $data['type'] ?? null,
            title: $data['title'] ?? null,
            status: isset($data['status']) ? (int) $data['status'] : 0,
            detail: $data['detail'] ?? null,
            instance: $data['instance'] ?? null,
            invalidParams: $invalidParams
        );
    }
}
