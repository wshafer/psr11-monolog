<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\LogmaticHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\LogmaticHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\LogmaticHandlerFactory
 */
class LogmaticHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'token' => 'some-token',
            'hostname' => 'some-host',
            'appname' => 'myApp',
            'useSSL' => false,
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $factory = new LogmaticHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(LogmaticHandler::class, $handler);
    }
}
