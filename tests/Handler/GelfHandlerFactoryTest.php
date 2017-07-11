<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Gelf\PublisherInterface;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;
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

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
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

    public function testGetPublisher()
    {
        $options = [
            'publisher' => 'my-service',
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

        $service = $this->factory->getPublisher($options);
        $this->assertEquals($mockService, $service);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testGetPublisherMissingService()
    {
        $options = [
            'publisher' => 'my-service',
        ];

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->factory->getPublisher($options);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testGetPublisherMissingConfig()
    {
        $options = [];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->factory->getPublisher($options);
    }
}
