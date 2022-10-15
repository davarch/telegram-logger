<?php

namespace Davarch\TelegramLogger\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

final class TelegramBotApi
{
    private const END_POINT = 'https://api.telegram.org/bot%s/sendMessage';

    public static function sendMessage(string $text, string $chatId = null): bool
    {
        try {
            $response = Http::post(
                sprintf(self::END_POINT, config('telegram-logger.bot_token')),
                [
                    'chat_id' => $chatId ?: config('telegram-logger.chat_id'),
                    'text' => $text,
                ]
            );

            $response->throw();

            return $response->successful();
        } catch (RequestException $exception) {
            logger()?->error($exception->getMessage(), [
                'url' => self::END_POINT,
                'class' => self::class,
                'method' => 'sendMessage',
            ]);
        }

        return false;
    }
}
