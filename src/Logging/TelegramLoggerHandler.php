<?php

namespace Davarch\TelegramLogger\Logging;

use Davarch\TelegramLogger\Services\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);
    }

    protected function write(array $record): void
    {
        TelegramBotApi::sendMessage($record['formatted']);
    }
}
