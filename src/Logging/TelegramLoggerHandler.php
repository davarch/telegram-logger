<?php

declare(strict_types=1);

namespace Davarch\TelegramLogger\Logging;

use Davarch\TelegramLogger\Contracts\TelegramBotApiContract;
use Davarch\TelegramLogger\Exceptions\TelegramBotApiException;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected const DEFAULT_FORMAT = "Date: %datetime% \n\nChannel: %channel% \n\nLevel: %level_name% \n\nMessage: %message% \n\nContext: %context% %extra%\n\n";

    public function __construct(array $config)
    {
        $format = $config['format'] ?? self::DEFAULT_FORMAT;
        $this->setFormatter(new LineFormatter($format, 'd.m.Y H:i', ignoreEmptyContextAndExtra: true));

        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);
    }

    /**
     * @throws TelegramBotApiException
     */
    protected function write(array $record): void
    {
        app(TelegramBotApiContract::class)->sendMessage($record['formatted']);
    }
}
