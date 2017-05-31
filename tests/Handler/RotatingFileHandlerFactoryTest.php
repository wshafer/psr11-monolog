<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\RotatingFileHandlerFactory;

class RotatingFileHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'filename' => '/tmp/stream_test.txt',
            'maxFiles' => 0,
            'level' => Logger::DEBUG,
            'bubble' => true,
            'filePermission' => null,
            'useLocking' => false,
        ];

        $factory = new RotatingFileHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(RotatingFileHandler::class, $handler);
    }
}
