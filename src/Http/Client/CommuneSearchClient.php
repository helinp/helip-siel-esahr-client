<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchResponseDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchRequestDto;

/**
 * Doc 4.1 Recherche des communes
 */
class CommuneSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        CommuneSearchRequestDto $request,
    ): CommuneSearchResponseDto {

        //commune?nameLocality=Bruxelles&postalCode=1190',
        $parameters = [
            'nameCommune' => $request->nameCommune ?? null,
            'nameLocality' => $request->nameLocality ?? null,
            'postalCode' => $request->postalCode ?? null,
        ];

        $parameters = array_filter($parameters, static fn ($value) => $value !== null);

        $data = $this->esahrHttpClient->get(
            'commune' . '?' . http_build_query($parameters),
            $accessToken,
            $request->toArray()
        );

        return CommuneSearchResponseDto::fromArray($data);
    }
}
