<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\Student\StudentDetailResponseDto;
use Helip\SielEsahrClient\Dto\Student\StudentMultipleResponseDto;
use Helip\SielEsahrClient\Dto\StudentSearch\StudentSearchCombinaisonRequestDto;
use Helip\SielEsahrClient\Dto\StudentSearch\StudentSearchIdEsahrRequestDto;

/**
 * Doc 4.4 Rechercher un élève
 */
final class StudentSearchClient extends AbstractClient
{
    public function searchByEsahrId(
        string $accessToken,
        StudentSearchIdEsahrRequestDto $studentSearchIdEsahrRequestDto
    ): StudentDetailResponseDto {

        $data = $this->esahrHttpClient->get(
            'students',
            $accessToken,
            $studentSearchIdEsahrRequestDto->toArray()
        );

        return StudentDetailResponseDto::fromArray($data);
    }

    public function searchByCombination(
        string $accessToken,
        StudentSearchCombinaisonRequestDto $student
    ): StudentMultipleResponseDto {
        $data = $this->esahrHttpClient->get(
            'students',
            $accessToken,
            $student->toArray()
        );

        return StudentMultipleResponseDto::fromArray($data);
    }
}
