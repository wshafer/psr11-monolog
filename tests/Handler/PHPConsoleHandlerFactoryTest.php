<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\PHPConsoleHandler;
use Monolog\Logger;
use PhpConsole\Connector;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\PHPConsoleHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\PHPConsoleHandlerFactory
 */
class PHPConsoleHandlerTest extends TestCase
{
    /** @var PHPConsoleHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new PHPConsoleHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'options'   => [],
            'connector' => 'my-service',
            'level'     => Logger::INFO,
            'bubble'    => false
        ];

        $mockService = $this->createMock(Connector::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(PHPConsoleHandler::class, $handler);
    }

    public function testGetConnector()
    {
        $options = [
            'connector' => 'my-service',
        ];

        $mockService = $this->createMock(Connector::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $service = $this->factory->getConnector($options);
        $this->assertEquals($mockService, $service);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testGetConnectorMissingService()
    {
        $options = [
            'connector' => 'my-service',
        ];

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->factory->getConnector($options);
    }

    public function testGetAmqpExchangeMissingConfig()
    {
        $options = [];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $result = $this->factory->getConnector($options);

        $this->assertNull($result);
    }
}
