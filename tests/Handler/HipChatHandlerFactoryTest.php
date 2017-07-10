<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\HipChatHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\HipChatHandlerFactory;

class HipChatHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'token' => 'sometokenhere',
            'room' => 'some-room',
            'name' => 'Error Log',
            'notify' => false,
            'level' => Logger::INFO,
            'bubble' => false,
            'useSSL' => false,
            'format' => 'html',
            'host' =>'api.hipchat.com',
        ];

        $factory = new HipChatHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(HipChatHandler::class, $handler);
    }
}
