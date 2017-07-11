<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\LogglyHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\LogglyHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\LogglyHandlerFactory
 */
class LogglyHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'token'  => 'token',
            'level'  => Logger::INFO,
            'bubble' => false
        ];

        $factory = new LogglyHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(LogglyHandler::class, $handler);
    }
}
