<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\ChromePHPHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\ChromePHPHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\ChromePHPHandlerFactory
 */
class ChromePHPHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'level'  => Logger::INFO,
            'bubble' => false
        ];

        $factory = new ChromePHPHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(ChromePHPHandler::class, $handler);
    }
}
