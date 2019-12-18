<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\AmqpHandler;
use Monolog\Logger;
use PhpAmqpLib\Channel\AMQPChannel;
use PHPUnit\Framework\MockObject\MockObject;
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

    /** @var MockObject|ContainerInterface */
    protected $mockContainer;

    protected function setup(): void
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
}
