<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\ValidationSearch\ValidationSearchMultipleResponseDto;
use Helip\SielEsahrClient\Dto\ValidationSearch\ValidationSearchRequestDto;

class ValidationSearchClient extends AbstractClient
{
    public function search(
        string $accessToken,
        ValidationSearchRequestDto $request,
    ): ValidationSearchMultipleResponseDto {

        $data = $this->esahrHttpClient->get(
            $this->getUri($request->schoolYear, $request->idEtab),
            $accessToken,
            $request->toArray()
        );

        return ValidationSearchMultipleResponseDto::fromArray($data);
    }

    private function getUri(int $schoolYear, ?int $idEtab): string
    {
        return sprintf(
            'validation?idEtab=%s&schoolYear=%d',
            $idEtab !== null ? (string)$idEtab : 'null',
            $schoolYear
        );
    }
}
