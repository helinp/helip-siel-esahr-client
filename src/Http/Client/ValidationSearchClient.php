<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\ValidationSearch\ValidationSearchMultipleResponseDto;
use Helip\SielEsahrClient\Dto\ValidationSearch\ValidationSearchRequestDto;

final class ValidationSearchClient extends AbstractClient
{

    public function search(
        string $accessToken,
        ValidationSearchRequestDto $request,
        int $idEtab,
        int $schoolYear
    ): ValidationSearchMultipleResponseDto {

        $data = $this->esahrHttpClient->get(
            $this->getUri($idEtab, $schoolYear),
            $accessToken,
            $request->toArray()
        );

        return ValidationSearchMultipleResponseDto::fromArray($data);
    }

    private function getUri(int $idEtab, int $schoolYear): string
    {
        return sprintf(
            'validation?idEtab=%d&schoolYear=%d',
            $idEtab,
            $schoolYear
        );
    }
}
