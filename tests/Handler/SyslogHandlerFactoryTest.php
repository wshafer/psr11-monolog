<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SyslogHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\SyslogHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SyslogHandlerFactory
 */
class SyslogHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'ident' => 'me',
            'facility' => LOG_USER,
            'level' => Logger::DEBUG,
            'bubble' => true,
            'logOpts' => LOG_PID,
        ];

        $factory = new SyslogHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(SyslogHandler::class, $handler);
    }
}
