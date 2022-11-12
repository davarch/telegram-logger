<?php

declare(strict_types=1);

namespace Davarch\TelegramLogger\Exceptions;

use Exception;

class TelegramBotApiException extends Exception
{
    public function __construct(protected $message = "", int $code = 0, protected array $context = [])
    {
        parent::__construct($message, $code, null);
    }

    public function report(): void
    {
        logger()?->error($this->getMessage(), $this->context);
    }
}
