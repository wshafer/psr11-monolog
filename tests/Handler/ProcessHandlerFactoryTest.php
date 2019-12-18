<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\ProcessHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\ProcessHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\ProcessHandlerFactory
 */
class ProcessHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'command' => 'some-command',
            'level' => Logger::DEBUG,
            'bubble' => true,
            'cwd' => __DIR__,
        ];

        $factory = new ProcessHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(ProcessHandler::class, $handler);
    }
}
