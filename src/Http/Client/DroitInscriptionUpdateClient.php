<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiUpdateResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionDi\InscriptionDiUpdateRequestDto;

/**
 * Doc 4.5.1 Modifier des droits d'inscriptions
 */
final class DroitInscriptionUpdateClient extends AbstractClient
{
    public function update(
        string $accessToken,
        InscriptionDiUpdateRequestDto $request
    ): InscriptionDiUpdateResponseDto {
        $data = $this->esahrHttpClient->put(
            'inscriptionDi',
            $accessToken,
            $request->toArray()
        );

        return InscriptionDiUpdateResponseDto::fromArray($data);
    }
}
