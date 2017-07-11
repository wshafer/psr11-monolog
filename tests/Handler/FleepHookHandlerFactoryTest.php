<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\FleepHookHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\FleepHookHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\FleepHookHandlerFactory
 */
class FleepHookHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'token'  => 'token',
            'level'  => Logger::INFO,
            'bubble' => false
        ];

        $factory = new FleepHookHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(FleepHookHandler::class, $handler);
    }
}
