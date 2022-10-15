<?php

namespace Davarch\TelegramLogger\Console;

use Davarch\TelegramLogger\ServiceProvider;
use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'telegram-logger:publish';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram-logger:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes and configures the Telegram Logger config.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $env = [];

        if (!$this->isEnvKeySet('TELEGRAM_LOGGER_BOT_TOKEN')) {
            $env['TELEGRAM_LOGGER_BOT_TOKEN'] = '';
        }

        if (!$this->isEnvKeySet('TELEGRAM_LOGGER_CHAT_ID')) {
            $env['TELEGRAM_LOGGER_CHAT_ID'] = '';
        }

        $this->info('Publishing Telegram Logger config...');
        $this->call('vendor:publish', ['--provider' => ServiceProvider::class]);

        if (!$this->setEnvValues($env)) {
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function setEnvValues(array $values): bool
    {
        $envFilePath = app()->environmentFilePath();

        $envFileContents = file_get_contents($envFilePath);

        if (!$envFileContents) {
            $this->error('Could not read `.env` file!');

            return false;
        }

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                if ($this->isEnvKeySet($envKey, $envFileContents)) {
                    $envFileContents = preg_replace("/^{$envKey}=.*?[\s$]/m", "{$envKey}={$envValue}\n", $envFileContents);

                    $this->info("Updated {$envKey} with new value in your `.env` file.");
                } else {
                    $envFileContents .= "{$envKey}={$envValue}\n";

                    $this->info("Added {$envKey} to your `.env` file.");
                }
            }
        }

        if (!file_put_contents($envFilePath, $envFileContents)) {
            $this->error('Updating the `.env` file failed!');

            return false;
        }

        return true;
    }

    private function isEnvKeySet(string $envKey, ?string $envFileContents = null): bool
    {
        $envFileContents = $envFileContents ?? file_get_contents(app()->environmentFilePath());

        return (bool)preg_match("/^{$envKey}=.*?[\s$]/m", $envFileContents);
    }
}
