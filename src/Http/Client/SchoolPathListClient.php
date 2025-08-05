<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\SchoolPath\SchoolPathRequestDto;
use Helip\SielEsahrClient\Dto\SchoolPath\SchoolPathsResponseDto;

/**
 * Doc 4.9.2 Lister le parcours scolaire d'un élève
 */
final class SchoolPathListClient extends AbstractClient
{
    public function list(
        string $accessToken,
        SchoolPathRequestDto $request
    ): SchoolPathsResponseDto {

        $data = $this->esahrHttpClient->get(
            'schoolpath',
            $accessToken,
            $request->toArray()
        );

        return SchoolPathsResponseDto::fromArray($data);
    }
}
