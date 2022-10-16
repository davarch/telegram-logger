<?php

namespace Davarch\TelegramLogger\Contracts;

use Davarch\TelegramLogger\Exceptions\TelegramBotApiException;

interface TelegramBotApiContract
{
    /**
     * @throws TelegramBotApiException
     */
    public function sendMessage(string $text, string $chatId = null): bool;
}