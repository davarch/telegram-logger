<?php

namespace Davarch\TelegramLogger;

use Illuminate\Support\ServiceProvider;

class TelegramLoggerServiceProvider extends ServiceProvider
{
    public function boot(): void {
        $this->publishes([
            __DIR__.'/../config/telegram-logger.php' => config_path('telegram-logger.php'),
        ], 'config');
    }
}
