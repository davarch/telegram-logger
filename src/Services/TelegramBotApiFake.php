<?php

declare(strict_types=1);

namespace Davarch\TelegramLogger\Services;

class TelegramBotApiFake extends TelegramBotApi
{
    protected static bool $success = true;

    public function returnTrue(): static
    {
        static::$success = true;

        return $this;
    }

    public function returnFalse(): static
    {
        static::$success = false;

        return $this;
    }

    public function sendMessage(string $text, string $chatId = null): bool
    {
        return static::$success;
    }
}
