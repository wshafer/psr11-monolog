<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use ArrayAccess;
use Monolog\Processor\WebProcessor;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\Processor\WebProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\WebProcessorFactory
 */
class WebProcessorFactoryTest extends TestCase
{
    /** @var WebProcessorFactory */
    protected $factory;

    /** @var MockObject|ContainerInterface */
    protected $mockContainer;

    protected function setup(): void
    {
        $this->factory = new WebProcessorFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'serverData'  => [],
            'extraFields' => []
        ];

        $handler = $this->factory->__invoke($options);
        $this->assertInstanceOf(WebProcessor::class, $handler);
    }

    public function testGetServerDataService()
    {
        $options = [
            'serverData' => 'my-service',
        ];

        $mockService = $this->createMock(ArrayAccess::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $service = $this->factory->getServerDataService($options);
        $this->assertEquals($mockService, $service);
    }

    public function testGetServerDataWithArray()
    {
        $options = [
            'serverData' => ['someKey' => 'someVar'],
        ];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $service = $this->factory->getServerDataService($options);
        $this->assertEquals($options['serverData'], $service);
    }

    public function testGetServerDataWithArrayObject()
    {
        $mockService = $this->createMock(ArrayAccess::class);

        $options = [
            'serverData' => $mockService,
        ];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $service = $this->factory->getServerDataService($options);
        $this->assertEquals($options['serverData'], $service);
    }

    public function testGetAmqpExchangeMissingConfig()
    {
        $options = [];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $result = $this->factory->getServerDataService($options);

        $this->assertEmpty($result);
    }

    public function testGetAmqpExchangeMissingService()
    {
        $this->expectException(MissingServiceException::class);

        $options = [
            'serverData' => 'my-service',
        ];

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->factory->getServerDataService($options);
    }
}
