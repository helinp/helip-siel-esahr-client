<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchResponseDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchRequestDto;

/**
 * Doc 4.1 Recherche des communes
 */
final class CommuneSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        CommuneSearchRequestDto $request,
    ): CommuneSearchResponseDto {
        $data = $this->esahrHttpClient->get(
            'commune',
            $accessToken,
            $request->toArray()
        );

        return CommuneSearchResponseDto::fromArray($data);
    }
}
