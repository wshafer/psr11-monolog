<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\RavenHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\RavenHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\RavenHandlerFactory
 */
class RavenHandlerFactoryTest extends TestCase
{
    /** @var RavenHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new RavenHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'client'       => 'my-service',
            'exchangeName' => 'logger',
            'level'        => Logger::INFO,
            'bubble'       => false
        ];

        $mockService = $this->createMock(\Raven_Client::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(RavenHandler::class, $handler);
    }

    public function testGetClient()
    {
        $options = [
            'client' => 'my-service',
        ];

        $mockService = $this->createMock(\Raven_Client::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $service = $this->factory->getClient($options);
        $this->assertEquals($mockService, $service);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testGetClientMissingService()
    {
        $options = [
            'client' => 'my-service',
        ];

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->factory->getClient($options);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testGetClientMissingConfig()
    {
        $options = [];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->factory->getClient($options);
    }
}
