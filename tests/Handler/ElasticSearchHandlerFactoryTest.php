<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Elastica\Client;
use Monolog\Handler\ElasticSearchHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\ElasticSearchHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\HandlerElasticSearchHandlerFactory
 */
class ElasticSearchHandlerFactoryTest extends TestCase
{
    /** @var ElasticSearchHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new ElasticSearchHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'client'      => 'my-service',
            'index'       => 'monolog',
            'type'        => 'record',
            'ignoreError' => false,
            'level'       => Logger::INFO,
            'bubble'      => false
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

        $this->assertInstanceOf(ElasticSearchHandler::class, $handler);
    }
}
