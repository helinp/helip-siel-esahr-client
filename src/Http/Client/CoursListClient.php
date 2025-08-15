<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\CoursList\CoursListeRequestDto;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeResponseDto;

/**
 * Doc 4.7 Lister des cours
 */
class CoursListClient extends AbstractClient
{
    public function list(
        string $accessToken,
        CoursListeRequestDto $request
    ): CoursListeResponseDto {

        // endpoint: listCours?situationDate=2023-01-01
        $parametres = [
            'situationDate' => $request->situationDate?->format('Y-m-d'),
        ];

        $parametres = array_filter($parametres, static fn ($value) => $value !== null);

        $data = $this->esahrHttpClient->get(
            'listCours' . '?' . http_build_query($parametres),
            $accessToken,
            $request->toArray()
        );

        return CoursListeResponseDto::fromArray($data);
    }
}
