<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Davarch\TelegramLogger\Exceptions\TelegramBotApiException;
use Davarch\TelegramLogger\Services\TelegramBotApi;
use Davarch\TelegramLogger\Contracts\TelegramBotApiContract;
use Tests\TestCase;

final class TelegramBotApiTest extends TestCase
{

    /**
     * @test
     * @return void
     * @throws TelegramBotApiException
     */
    public function it_send_message_success_by_fake_instance(): void
    {
        TelegramBotApi::fake()
            ->returnTrue();

        $result = app(TelegramBotApiContract::class)->sendMessage('Testing');

        $this->assertTrue($result);
    }

    /**
     * @test
     * @return void
     * @throws TelegramBotApiException
     */
    public function it_send_message_fail_by_fake_instance(): void
    {
        TelegramBotApi::fake()
            ->returnFalse();

        $result = app(TelegramBotApiContract::class)->sendMessage('Testing');

        $this->assertFalse($result);
    }
}
