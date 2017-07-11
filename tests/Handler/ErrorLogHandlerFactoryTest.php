<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\ErrorLogHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\ErrorLogHandlerFactory
 */
class ErrorLogHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'messageType' => ErrorLogHandler::OPERATING_SYSTEM,
            'level' => Logger::DEBUG,
            'bubble' => true,
            'expandNewlines' => false,
        ];

        $factory = new ErrorLogHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(ErrorLogHandler::class, $handler);
    }
}
