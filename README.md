# Telegram Logger for Laravel

## Install

`composer require davarch/telegram-logger`

`php artisan telegram-logger:publish`

### Add to config/logging.php:

```php
'channels' => [
    ...
    'telegram' => [
        'driver' => 'custom',
        'via' => \Davarch\TelegramLogger\Logging\TelegramLoggerFactory::class,
        'level' => env('LOG_LEVEL', 'debug'),
    ],
],
```

### Edit to .env file:
```dotenv
TELEGRAM_LOGGER_BOT_TOKEN=YOUR_BOT_TOKEN
TELEGRAM_LOGGER_CHAT_ID=YOUR_CHAT_ID
```

## Usage
```php
logger()?->channel('telegram')->debug('debug message');
```
