<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Gelf\PublisherInterface;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\GelfHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\GelfHandlerFactory
 */
class GelfHandlerFactoryTest extends TestCase
{
    /** @var GelfHandlerFactory */
    protected $factory;

    /** @var MockObject|ContainerInterface */
    protected $mockContainer;

    protected function setup(): void
    {
        $this->factory = new GelfHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'publisher' => 'my-service',
            'level'     => Logger::INFO,
            'bubble'    => false
        ];

        $mockService = $this->createMock(PublisherInterface::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(GelfHandler::class, $handler);
    }
}
