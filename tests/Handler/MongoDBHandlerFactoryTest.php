<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use MongoDB\Client;
use Monolog\Handler\MongoDBHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\MongoDBHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\MongoDBHandlerFactory
 */
class RedisHandlerFactoryTest extends TestCase
{
    /** @var MongoDBHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new MongoDBHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'client'     => 'my-service',
            'database'   => 'logger',
            'collection' => 'logger',
            'level'      => Logger::INFO,
            'bubble'     => false
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

        $this->assertInstanceOf(MongoDBHandler::class, $handler);
    }
}
