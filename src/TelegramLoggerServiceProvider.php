<?php

namespace Davarch\TelegramLogger;

use Davarch\TelegramLogger\Contracts\TelegramBotApiContract;
use Davarch\TelegramLogger\Services\TelegramBotApi;
use Illuminate\Support\ServiceProvider;
use Davarch\TelegramLogger\Console\PublishCommand;

class TelegramLoggerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(TelegramBotApiContract::class, TelegramBotApi::class);

        $this->publishes([
            __DIR__.'/../config/telegram-logger.php' => config_path('telegram-logger.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishCommand::class,
            ]);
        }
    }
}
