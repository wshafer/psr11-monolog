<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\FirePHPHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\FirePHPHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\FirePHPHandlerFactory
 */
class FirePHPHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'level'  => Logger::INFO,
            'bubble' => false
        ];

        $factory = new FirePHPHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(FirePHPHandler::class, $handler);
    }
}
