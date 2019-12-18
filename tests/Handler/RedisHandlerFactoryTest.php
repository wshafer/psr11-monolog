<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\RedisHandler;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Predis\Client;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\RedisHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\RedisHandlerFactory
 */
class RedisHandlerFactoryTest extends TestCase
{
    /** @var RedisHandlerFactory */
    protected $factory;

    /** @var MockObject|ContainerInterface */
    protected $mockContainer;

    protected function setup(): void
    {
        $this->factory = new RedisHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'client'  => 'my-service',
            'key'     => 'logger',
            'level'   => Logger::INFO,
            'bubble'  => false,
            'capSize' => 0,
        ];

        $mockService = $this->createMock(Client::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(RedisHandler::class, $handler);
    }
}
