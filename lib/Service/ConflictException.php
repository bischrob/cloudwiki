<?php

declare(strict_types=1);

namespace OCA\CloudWiki\Service;

use RuntimeException;

class ConflictException extends RuntimeException
{
    public function __construct(
        private string $currentEtag,
        private int $currentMtime,
    ) {
        parent::__construct('File was modified since it was loaded');
    }

    public function getCurrentEtag(): string
    {
        return $this->currentEtag;
    }

    public function getCurrentMtime(): int
    {
        return $this->currentMtime;
    }
}
