<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchMultipleResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchRequestDto;

/**
 * Doc 4.9.1 Recherche les inscription aux cours
 */
class InscriptionCoursSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        InscriptionCoursSearchRequestDto $request
    ): InscriptionCoursSearchMultipleResponseDto {

        // endpoint: 'inscriptionCours?idEsahr=15678-92&idEtab=12345&schoolYear=2023&situationDate=2023-09-01',
        $parameters = [
            'idEsahr'       => $request->idEsahr->value(),
            'idEtab'        => $request->idEtab,
            'schoolYear'    => $request->schoolYear,
            'situationDate' => $request->situationDate?->format('Y-m-d'),
        ];

        $parameters = array_filter($parameters, static fn ($value) => $value !== null);

        $data = $this->esahrHttpClient->get(
            'inscriptionCours' . '?' . http_build_query($parameters),
            $accessToken,
            $request->toArray()
        );

        return InscriptionCoursSearchMultipleResponseDto::fromArray($data);
    }
}
