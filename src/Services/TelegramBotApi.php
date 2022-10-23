<?php

namespace Davarch\TelegramLogger\Services;

use Davarch\TelegramLogger\Contracts\TelegramBotApiContract;
use Davarch\TelegramLogger\Exceptions\TelegramBotApiException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class TelegramBotApi implements TelegramBotApiContract
{
    private const END_POINT = 'https://api.telegram.org/bot%s/sendMessage';

    /**
     * @throws TelegramBotApiException
     */
    public function sendMessage(string $text, string $chatId = null): bool
    {
        try {
            return Http::post(
                sprintf(self::END_POINT, config('telegram-logger.bot_token')),
                [
                    'chat_id' => $chatId ?: config('telegram-logger.chat_id'),
                    'parse_mode' => 'MarkdownV2',
                    'text' => "`$text`"
                ]
            )->throw()->successful();
        } catch (RequestException $exception) {
            report(
                new TelegramBotApiException(
                    $exception->getMessage(), $exception->getCode(),
                    [
                        'url' => self::END_POINT,
                        'class' => self::class,
                        'method' => 'sendMessage',
                    ]
                )
            );
        }
    }
}
