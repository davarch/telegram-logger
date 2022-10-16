<?php

namespace Davarch\TelegramLogger\Logging;

use Monolog\Logger;

class TelegramLoggerFactory
{
    public function __invoke(array $config): Logger
    {
        return new Logger('telegram', [new TelegramLoggerHandler($config)]);
    }
}
