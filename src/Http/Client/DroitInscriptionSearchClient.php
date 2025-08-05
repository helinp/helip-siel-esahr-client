<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiSearchResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiSearchRequestDto;

/**
 * Doc 4.5.2 Rechercher des droits d'inscriptions
 */
final class DroitInscriptionSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        InscriptionDiSearchRequestDto $request
    ): InscriptionDiSearchResponseDto {
        $data = $this->esahrHttpClient->get(
            'inscriptionDi',
            $accessToken,
            $request->toArray()
        );

        return InscriptionDiSearchResponseDto::fromArray($data);
    }
}
