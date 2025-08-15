<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiSearchResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiSearchRequestDto;

/**
 * Doc 4.5.2 Rechercher des droits d'inscriptions
 */
class DroitInscriptionSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        InscriptionDiSearchRequestDto $request
    ): InscriptionDiSearchResponseDto {

        // endpoint: 'inscriptionDi?idEsahr=123456-01&idEtab=123456&schoolYear=2023',
        $parameters = [
            'idEsahr'    => $request->idEsahr->value(),
            'idEtab'     => $request->etabResponsable,
            'schoolYear' => $request->schoolYear,
        ];

        $data = $this->esahrHttpClient->get(
            'inscriptionDi' . '?' . http_build_query($parameters),
            $accessToken,
            $request->toArray()
        );

        return InscriptionDiSearchResponseDto::fromArray($data);
    }
}
