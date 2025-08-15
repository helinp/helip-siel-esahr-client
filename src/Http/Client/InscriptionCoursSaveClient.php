<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursSave\InscriptionCoursSaveRequestDto;

/**
 * Doc 4.8.1 Enregistrer un cours
 */
class InscriptionCoursSaveClient extends AbstractClient
{
    public function save(
        string $accessToken,
        InscriptionCoursSaveRequestDto $request
    ): InscriptionCoursResponseDto {
        $data = $this->esahrHttpClient->post(
            'inscriptionCours',
            $accessToken,
            $request->toArray()
        );

        return InscriptionCoursResponseDto::fromArray($data);
    }
}
