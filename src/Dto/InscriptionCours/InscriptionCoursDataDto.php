<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Dto\InscriptionCours;

use DateTimeImmutable;
use Helip\SielEsahrClient\Enum\FiliereCodeEnum;
use Helip\SielEsahrClient\Enum\DomaineCodeEnum;

final readonly class InscriptionCoursDataDto
{
    /**
     * @param DateTimeImmutable $inscriptionDate Date d’inscription au cours (format YYYY-MM-DD)
     * @param DomaineCodeEnum   $domaineCode     Code du domaine de formation (Musique, Théâtre, etc.)
     * @param int               $coursCode       Code du cours (! id SIEL)
     * @param FiliereCodeEnum   $filiere         Filière de formation (ex: F, Q, T, etc.)
     * @param string            $annee           Année de la formation (ex: "5", "1A", "P1", etc.)
     * @param int               $periode         Nombre de périodes suivies (1-20)
     */
    public function __construct(
        public DateTimeImmutable $inscriptionDate,   // format YYYY-MM-DD
        public DomaineCodeEnum $domaineCode,
        public int $coursCode,
        public FiliereCodeEnum $filiere,
        public string $annee, // Année de la formation
        public int $periode, // Nombre de périodes suivies
    ) {
    }

    public function toArray(): array
    {
        return [
            'inscriptionDate' => $this->inscriptionDate->format('Y-m-d'),
            'domaineCode'     => $this->domaineCode->value,
            'coursCode'       => $this->coursCode,
            'filiere'         => $this->filiere->value,
            'annee'           => $this->annee,
            'periode'         => $this->periode,
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            DateTimeImmutable::createFromFormat('Y-m-d', $data['inscriptionDate']),
            DomaineCodeEnum::from($data['domaineCode']),
            (int) $data['coursCode'],
            FiliereCodeEnum::from($data['filiere']),
            $data['annee'],
            $data['periode'],
        );
    }
}
