<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Elastica\Client;
use Monolog\Handler\ElasticaHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\ElasticaHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\ElasticaHandlerFactory
 */
class ElasticaHandlerFactoryTest extends TestCase
{
    /** @var ElasticaHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new ElasticaHandlerFactory();
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

        $this->assertInstanceOf(ElasticaHandler::class, $handler);
    }
}
