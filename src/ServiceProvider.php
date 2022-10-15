<?php

namespace Davarch\TelegramLogger;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Davarch\TelegramLogger\Console\PublishCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void {
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
