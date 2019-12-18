<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\TestHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\TestHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\TestHandlerFactory
 */
class TestHandlerFactoryTest extends TestCase
{
    /** @var TestHandlerFactory */
    protected $factory;

    protected function setup(): void
    {
        $this->factory = new TestHandlerFactory();
    }

    public function testInvoke()
    {
        $options = [
            'level'  => Logger::INFO,
            'bubble' => false
        ];

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(TestHandler::class, $handler);
    }
}
