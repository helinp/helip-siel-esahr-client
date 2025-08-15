<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\InscriptionCours\InscriptionCoursResponseDto;
use Helip\SielEsahrClient\Dto\InscriptionCoursUpdate\InscriptionCoursUpdateRequestDto;

/**
 * Doc 4.8.2 Modifier un cours
 */
class InscriptionCoursUpdateClient extends AbstractClient
{
    public function update(
        string $accessToken,
        int $idInscript,
        InscriptionCoursUpdateRequestDto $inscriptionCoursUpdateRequestDto
    ): InscriptionCoursResponseDto {
        $data = $this->esahrHttpClient->put(
            $this->getUri($idInscript),
            $accessToken,
            $inscriptionCoursUpdateRequestDto->toArray()
        );

        return InscriptionCoursResponseDto::fromArray($data);
    }

    private function getUri(int $idInscript): string
    {
        return sprintf('inscriptionCours?idInscript=%d', $idInscript);
    }
}
