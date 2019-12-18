<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\TelegramBotHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\TelegramBotHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\TelegramBotHandlerFactory
 */
class TelegramBotHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'apiKey' => 'some-key',
            'channel' => 'some-channel',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $factory = new TelegramBotHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(TelegramBotHandler::class, $handler);
    }
}
