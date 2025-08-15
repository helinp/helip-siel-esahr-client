<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineSearch\InscriptionRegulariteDomaineRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineSearch\InscriptionRegulariteDomaineMultipleResponseDto;

/**
 * 4.6.2 Inscription régularité domaine
 */
class InscriptionRegulariteDomaineSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        InscriptionRegulariteDomaineRequestDto $request
    ): InscriptionRegulariteDomaineMultipleResponseDto {

        // Endpoint: {{baseUrl}}/inscriptionRegulariteDomaine?idEsahr=<string>&idEtab=<integer>&schoolYear=<integer>
        $parameters = [
            'idEsahr' => $request->idEsahr->value(),
            'idEtab' => $request->idEtab,
            'schoolYear' => $request->schoolYear,
        ];

        $parameters = array_filter($parameters, static fn ($value) => $value !== null);

        $data = $this->esahrHttpClient->get(
            'inscriptionRegulariteDomaine' . '?' . http_build_query($parameters),
            $accessToken,
            $request->toArray()
        );

        return InscriptionRegulariteDomaineMultipleResponseDto::fromArray($data);
    }
}
