<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\NoopHandler;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\NoopHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\NoopHandlerFactory
 */
class NoopHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $factory = new NoopHandlerFactory();
        $handler = $factory([]);

        $this->assertInstanceOf(NoopHandler::class, $handler);
    }
}
