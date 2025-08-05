<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchRequestDto;
use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchResponseDto;

/**
 * Doc 4.11 Recherche des pays
 */
final class PaysSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        PaysSearchRequestDto $request,
    ): PaysSearchResponseDto {
        $data = $this->esahrHttpClient->get(
            'country',
            $accessToken,
            $request->toArray()
        );

        return PaysSearchResponseDto::fromArray($data);
    }
}
