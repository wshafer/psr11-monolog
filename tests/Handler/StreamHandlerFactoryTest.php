<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\StreamHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\StreamHandlerFactory
 */
class StreamHandlerFactoryTest extends TestCase
{
    public function testInvokeWithFilePath()
    {
        $options = [
            'stream' => '/tmp/stream_test.txt',
            'level' => Logger::DEBUG,
            'bubble' => true,
            'filePermission' => null,
            'useLocking' => false,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockContainer->expects($this->once())
            ->method('has')
            ->willReturn(false);

        $factory = new StreamHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);

        $this->assertInstanceOf(StreamHandler::class, $handler);
    }

    public function testInvokeWithResource()
    {
        $options = [
            'stream' => fopen('/tmp/test-stream-resource.txt', 'w+'),
            'level' => Logger::DEBUG,
            'bubble' => true,
            'filePermission' => null,
            'useLocking' => false,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockContainer->expects($this->once())
            ->method('has')
            ->willReturn(false);

        $factory = new StreamHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);

        $this->assertInstanceOf(StreamHandler::class, $handler);
    }

    public function testInvokeWithService()
    {
        $resource = fopen('/tmp/test-stream-service.txt', 'w+');

        $options = [
            'stream' => 'my-service',
            'level' => Logger::DEBUG,
            'bubble' => true,
            'filePermission' => null,
            'useLocking' => false,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockContainer->expects($this->once())
            ->method('has')
            ->willReturn(true);

        $mockContainer->expects($this->once())
            ->method('get')
            ->willReturn($resource);

        $factory = new StreamHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);

        $this->assertInstanceOf(StreamHandler::class, $handler);
    }
}
