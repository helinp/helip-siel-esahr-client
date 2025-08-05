<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineUpdate\InscriptionRegulariteDomaineRequestDto;
use Helip\SielEsahrClient\Dto\InscriptionRegulariteDomaineUpdate\InscriptionRegulariteDomaineResponseDto;

/**

 */
final class InscriptionRegulariteDomaineUpdateClient extends AbstractClient
{
    public function Update(
        string $accessToken,
        InscriptionRegulariteDomaineRequestDto $request
    ): InscriptionRegulariteDomaineResponseDto {
        $data = $this->esahrHttpClient->put(
            'inscriptionRegulariteDomaine',
            $accessToken,
            $request->toArray()
        );

        return InscriptionRegulariteDomaineResponseDto::fromArray($data);
    }
}
