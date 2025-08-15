<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Dto\CodeExemptionSearch\CodeExemptionSearchResponseDto;

/**
 * Doc 4.2 Recherche des codes d'exemption (page 66)
 */
class CodeExemptionListClient extends AbstractClient
{
    public function list(
        string $accessToken
    ): CodeExemptionSearchResponseDto {
        $data = $this->esahrHttpClient->get(
            'exemptionCode',
            $accessToken
        );

        return CodeExemptionSearchResponseDto::fromArray($data);
    }
}
