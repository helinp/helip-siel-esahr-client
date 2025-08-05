<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\Student\StudentResponseDto;
use Helip\SielEsahrClient\Dto\StudentAdd\StudentDetailsRequestDto;

/**
 * Doc: 4.3.1 Sauvegarder un élève
 */
final class StudentSaveClient extends AbstractClient
{
    public function save(
        string $accessToken,
        StudentDetailsRequestDto $studentDetails
    ): StudentResponseDto {
        $data = $this->esahrHttpClient->post(
            'students',
            $accessToken,
            $studentDetails->toArray()
        );

        return StudentResponseDto::fromArray($data);
    }
}
