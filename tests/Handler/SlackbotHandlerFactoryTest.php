<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SlackbotHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\SlackbotHandlerFactory;

class HipChatHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'slackTeam' => 'team',
            'token' => 'token',
            'channel' => 'Monolog',
            'level' => Logger::INFO,
            'bubble' => false
        ];

        $factory = new SlackbotHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(SlackbotHandler::class, $handler);
    }
}
