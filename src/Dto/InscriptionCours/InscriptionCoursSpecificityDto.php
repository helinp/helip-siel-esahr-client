<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCours;

use DateTimeImmutable;

final readonly class InscriptionCoursSpecificityDto
{
    public function __construct(
        public ?DateTimeImmutable $abandonDate,
        public ?string $group,
        public ?string $timetable,
        public ?string $professor,
        public ?string $impl,
        public ?bool $success,
    ) {
    }

    public function toArray(): array
    {
        return [
            'abandonDate' => $this->abandonDate?->format('Y-m-d'),
            'group'       => $this->group,
            'timetable'   => $this->timetable,
            'professor'   => $this->professor,
            'impl'        => $this->impl,
            'success'     => $this->success ? 'O' : 'N',
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            abandonDate: isset($data['abandonDate']) ? DateTimeImmutable::createFromFormat('Y-m-d', $data['abandonDate']) : null,
            group: $data['group']         ?? null,
            timetable: $data['timetable'] ?? null,
            professor: $data['professor'] ?? null,
            impl: $data['impl']           ?? null,
            success: isset($data['success']) ? $data['success'] === 'O' : null,
        );
    }
}
