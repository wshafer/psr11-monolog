<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\LogEntriesHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\LogEntriesHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\LogEntriesHandlerFactory
 */
class LogEntriesHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'token'  => 'token',
            'useSSL' => true,
            'level'  => Logger::INFO,
            'bubble' => false
        ];

        $factory = new LogEntriesHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(LogEntriesHandler::class, $handler);
    }
}
