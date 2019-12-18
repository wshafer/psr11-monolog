<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\NullHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\NullHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\NullHandlerFactory
 */
class NullHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'level' => Logger::DEBUG,
        ];

        $factory = new NullHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(NullHandler::class, $handler);
    }
}
