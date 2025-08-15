<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchRequestDto;
use Helip\SielEsahrClient\Dto\PaysSearch\PaysSearchResponseDto;

/**
 * Doc 4.11 Recherche des pays
 */
class PaysSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        PaysSearchRequestDto $request,
    ): PaysSearchResponseDto {

        // endpoint: 'country?name=Belgique'
        $parameters = [
            'name' => $request->name,
        ];

        $data = $this->esahrHttpClient->get(
            'country' . '?' . http_build_query($parameters),
            $accessToken,
            $request->toArray()
        );

        return PaysSearchResponseDto::fromArray($data);
    }
}
