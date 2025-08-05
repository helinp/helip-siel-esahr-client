<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionDi;

use Helip\SielEsahrClient\Contract\AbstractResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * Modifier les droits d'inscription (4.5.1) / Réponse
 */
final readonly class NoModificationResponseDto extends AbstractResponseDto
{
    public function __construct(
        public string $type,
        public string $title,
        public int $status,
        public string $detail,
        public string $instance,
        public string $id
    ) {
    }

    protected static function fromArrayInterne(array $data): static
    {
        if (!isset($data['type'], $data['title'], $data['status'], $data['detail'], $data['instance'], $data['id'])) {
            throw new EsahrApiResponseException(
                'Invalid response format: required keys are missing.',
                0,
                null,
                $data
            );
        }

        return new self(
            type: $data['type'],
            title: $data['title'],
            status: $data['status'],
            detail: $data['detail'],
            instance: $data['instance'],
            id: $data['id']
        );
    }
}
