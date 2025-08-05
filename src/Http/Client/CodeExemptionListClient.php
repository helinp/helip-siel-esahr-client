<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Error;
use Helip\SielEsahrClient\Dto\CodeExemptionSearch\CodeExemptionSearchResponseDto;
use Helip\SielEsahrClient\Dto\Common\ErrorResponseDto;
use Helip\SielEsahrClient\Exception\EsahrApiException;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;

/**
 * Doc 4.2 Recherche des codes d'exemption (page 66)
 */
final class CodeExemptionListClient extends AbstractClient
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
