<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Exception;

use Helip\SielEsahrClient\Dto\Common\ErrorResponseDto;
use RuntimeException;
use Throwable;

final class EsahrApiException extends RuntimeException
{
    public function __construct(
        public readonly ErrorResponseDto $problemDetails,
        ?Throwable $previous = null
    ) {
        parent::__construct($problemDetails->detail ?? 'ESAHR API error', $problemDetails->status, $previous);
    }
}
