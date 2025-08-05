<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchMultipleResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSearch\InscriptionCoursSearchRequestDto;

/**
 * Doc 4.9.1 Recherche les inscription aux cours
 */
final class InscriptionCoursSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        InscriptionCoursSearchRequestDto $request
    ): InscriptionCoursSearchMultipleResponseDto {
        $data = $this->esahrHttpClient->get(
            'inscriptionCours',
            $accessToken,
            $request->toArray()
        );

        return InscriptionCoursSearchMultipleResponseDto::fromArray($data);
    }
}
