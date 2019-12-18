<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Doctrine\CouchDB\CouchDBClient;
use Monolog\Handler\DoctrineCouchDBHandler;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\DoctrineCouchDBHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\DoctrineCouchDBHandlerFactory
 */
class DoctrineCouchDBHandlerFactoryTest extends TestCase
{
    /** @var DoctrineCouchDBHandlerFactory */
    protected $factory;

    /** @var MockObject|ContainerInterface */
    protected $mockContainer;

    protected function setup(): void
    {
        $this->factory = new DoctrineCouchDBHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'client'  => 'my-service',
            'level'   => Logger::INFO,
            'bubble'  => false
        ];

        $mockService = $this->createMock(CouchDBClient::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(DoctrineCouchDBHandler::class, $handler);
    }
}
