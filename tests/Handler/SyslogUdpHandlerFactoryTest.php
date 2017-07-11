<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SyslogUdpHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\SyslogUdpHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\FleepHookHandlerFactory
 */
class SyslogUdpHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'host'     => 'somewhere.com',
            'port'     => 513,
            'facility' => 'Me',
            'level'    => Logger::INFO,
            'bubble'   => false,
            'ident'    => 'me-too',
        ];

        $factory = new SyslogUdpHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(SyslogUdpHandler::class, $handler);
    }
}
