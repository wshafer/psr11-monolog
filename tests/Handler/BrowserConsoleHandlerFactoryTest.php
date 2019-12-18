<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\BrowserConsoleHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\BrowserConsoleHandlerFactory
 */
class BrowserConsoleHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'level'  => Logger::INFO,
            'bubble' => false
        ];

        $factory = new BrowserConsoleHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(BrowserConsoleHandler::class, $handler);
    }
}
