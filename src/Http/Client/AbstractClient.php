<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Client;

use Helip\SielEsahrClient\Http\Transport\EsahrHttpClientInterface;

abstract class AbstractClient
{
    public function __construct(
        protected readonly EsahrHttpClientInterface $esahrHttpClient
    ) {
    }
}
