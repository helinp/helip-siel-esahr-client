<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\CoursList\CoursListeRequestDto;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeResponseDto;

/**
 * Doc 4.7 Lister des cours
 */
final class CoursListClient extends AbstractClient
{
    public function list(
        string $accessToken,
        CoursListeRequestDto $request
    ): CoursListeResponseDto {
        $data = $this->esahrHttpClient->get(
            'listCours',
            $accessToken,
            $request->toArray()
        );

        return CoursListeResponseDto::fromArray($data);
    }
}
