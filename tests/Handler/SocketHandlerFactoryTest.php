<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SocketHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\SocketHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SocketHandlerFactory
 */
class SocketHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'connectionString' => 'connect',
            'timeout'          => 300,
            'writeTimeout'     => 900,
            'level'            => Logger::INFO,
            'bubble'           => false
        ];

        $factory = new SocketHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(SocketHandler::class, $handler);
        $this->assertEquals($options['timeout'], $handler->getConnectionTimeout());
        $this->assertEquals($options['writeTimeout'], $handler->getWritingTimeout());
        $this->assertEquals($options['writeTimeout'], $handler->getTimeout());
    }
}
