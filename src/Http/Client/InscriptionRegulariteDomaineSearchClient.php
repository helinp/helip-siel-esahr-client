<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineSearch\InscriptionRegulariteDomaineRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineSearch\InscriptionRegulariteDomaineMultipleResponseDto;

/**

 */
final class InscriptionRegulariteDomaineSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        InscriptionRegulariteDomaineRequestDto $request
    ): InscriptionRegulariteDomaineMultipleResponseDto {
        $data = $this->esahrHttpClient->get(
            'inscriptionRegulariteDomaine',
            $accessToken,
            $request->toArray()
        );

        return InscriptionRegulariteDomaineMultipleResponseDto::fromArray($data);
    }
}
