<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Exception;

use RuntimeException;

class EsahrNoChangeResponseException extends RuntimeException
{
    public function __construct(
        public readonly string $title = 'No modification',
        public readonly ?string $detail = 'No changes detected',
        public readonly int $status = 200,
        public readonly ?string $type = null,
        public readonly ?string $instance = null,
        public readonly ?string $id = null
    ) {
        $message = sprintf(
            'No change (HTTP %d): %s%s%s%s%s',
            $status,
            $title,
            $this->detail ? ' - ' . $this->detail : '',
            $this->type ? ' [type='    . $this->type . ']' : '',
            $this->instance ? ' [instance=' . $this->instance . ']' : '',
            $this->id ? ' [id='      . $this->id . ']' : ''
        );

        parent::__construct($message, $status);
    }
}
