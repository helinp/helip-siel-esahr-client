<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\StudentAdd\StudentDetailsRequestDto;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

/**
 * Doc: 4.3.2 Modifier un élève
 */
final class StudentUpdateClient extends AbstractClient
{
    public function update(
        string $accessToken,
        IdEsahr $idEsahr,
        StudentDetailsRequestDto $studentDetails
    ): void {
        $parameters = [
            'idEsahr' => $idEsahr->value(),
        ];

        $this->esahrHttpClient->put(
            'students' . '?' . http_build_query($parameters),
            $accessToken,
            $studentDetails->toArray()
        );
    }
}
