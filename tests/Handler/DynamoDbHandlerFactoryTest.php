<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Aws\DynamoDb\DynamoDbClient;
use Monolog\Handler\DynamoDbHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\DynamoDbHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\DynamoDbHandlerFactory
 */
class DynamoDbHandlerFactoryTest extends TestCase
{
    /** @var DynamoDbHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new DynamoDbHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'client'  => 'my-service',
            'table'   => 'monolog',
            'level'   => Logger::INFO,
            'bubble'  => false
        ];

        $mockService = $this->createMock(DynamoDbClient::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(DynamoDbHandler::class, $handler);
    }
}
