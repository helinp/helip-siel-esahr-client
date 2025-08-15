<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\Student\StudentMultipleResponseDto;
use Helip\SielEsahrClient\Dto\StudentAdd\StudentDetailsResponseDto;
use Helip\SielEsahrClient\Dto\StudentSearch\StudentSearchCombinaisonRequestDto;
use Helip\SielEsahrClient\Dto\StudentSearch\StudentSearchIdEsahrRequestDto;

/**
 * Doc 4.4 Rechercher un élève
 */
class StudentSearchClient extends AbstractClient
{
    public function searchByEsahrId(
        string $accessToken,
        StudentSearchIdEsahrRequestDto $studentSearchIdEsahrRequestDto
    ): StudentDetailsResponseDto {

        // endpoint: /students/:idEsahr?fromDate=4272-51-68
        $parameters = [
            'fromDate' => $studentSearchIdEsahrRequestDto->fromDate?->format('Y-m-d') ?? null,
        ];

        $parameters = array_filter($parameters, static fn ($value) => $value !== null);

        $uri = 'students/' . $studentSearchIdEsahrRequestDto->idEsahr->value()
            . '?' . http_build_query($parameters);

        $data = $this->esahrHttpClient->get(
            $uri,
            $accessToken,
            []
        );

        return StudentDetailsResponseDto::fromArray($data);
    }

    public function searchByCombination(
        string $accessToken,
        StudentSearchCombinaisonRequestDto $student
    ): StudentMultipleResponseDto {

        // endpoint: students?ssin=97277120835&lastName=Doe&firstName=John&birthDate=2000-01-01&genderCode=M
        $parameters = [
            'ssin' => $student->ssin?->value(),
            'lastName' => $student->lastName?->value(),
            'firstName' => $student->firstName?->value(),
            'birthDate' => $student->birthDate?->format(),
            'genderCode' => $student->genderCode?->value(),
        ];

        $parameters = array_filter($parameters, static fn ($value) => $value !== null);

        $data = $this->esahrHttpClient->get(
            'students' . '?' . http_build_query($parameters),
            $accessToken,
            $student->toArray()
        );

        return StudentMultipleResponseDto::fromArray($data);
    }
}
