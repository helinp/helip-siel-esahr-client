<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\ValidationUpdate\ValidationUpdateResponseDto;
use Helip\SielEsahrClient\Dto\ValidationUpdate\ValidationUpdateRequestDto;

class ValidationUpdateClient extends AbstractClient
{
    public function update(
        string $accessToken,
        ValidationUpdateRequestDto $request
    ): ValidationUpdateResponseDto {
        $data = $this->esahrHttpClient->post(
            $this->getUri(
                $request->idEtab,
                $request->schoolYear,
                $request->validationType,
                $request->source,
                $request->date
            ),
            $accessToken,
            []
        );

        return ValidationUpdateResponseDto::fromArray($data);
    }

    private function getUri(
        int $idEtab,
        int $schoolYear,
        string $validationType,
        string $source,
        DateTimeImmutable $date
    ): string {
        return sprintf(
            'validation?idEtab=%d&schoolYear=%d&validationType=%s&source=%s&date=%s',
            $idEtab,
            $schoolYear,
            $validationType,
            $source,
            $date->format('Y-m-d')
        );
    }
}
