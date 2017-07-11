<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\AmqpHandler;
use Monolog\Logger;
use PhpAmqpLib\Channel\AMQPChannel;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\AmqpHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\AmqpHandlerFactory
 */
class AmqpHandlerFactoryTest extends TestCase
{
    /** @var AmqpHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new AmqpHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'exchange'     => 'my-service',
            'exchangeName' => 'logger',
            'level'        => Logger::INFO,
            'bubble'       => false
        ];

        $mockService = $this->createMock(AMQPChannel::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(AmqpHandler::class, $handler);
    }

    public function testGetAmqpExchange()
    {
        $options = [
            'exchange'     => 'my-service',
        ];

        $mockService = $this->createMock(AMQPChannel::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $service = $this->factory->getAmqpExchange($options);
        $this->assertEquals($mockService, $service);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testGetAmqpExchangeMissingService()
    {
        $options = [
            'exchange'     => 'my-service',
        ];

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->factory->getAmqpExchange($options);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testGetAmqpExchangeMissingConfig()
    {
        $options = [];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->factory->getAmqpExchange($options);
    }
}
