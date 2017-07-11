<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\FlowdockHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\FlowdockHandlerFactory;

class FlowdockHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'apiToken' => 'sometokenhere',
            'level' => Logger::INFO,
            'bubble' => false
        ];

        $factory = new FlowdockHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(FlowdockHandler::class, $handler);
    }
}
