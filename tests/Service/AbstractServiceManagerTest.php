<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Service;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Config\HandlerConfig;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\MapperInterface;
use WShafer\PSR11MonoLog\Service\AbstractServiceManager;
use WShafer\PSR11MonoLog\Test\Stub\FactoryStub;
use WShafer\PSR11MonoLog\Test\Stub\HandlerStub;
use WShafer\PSR11MonoLog\Test\Stub\ServiceManagerStub;

/**
 * @covers \WShafer\PSR11MonoLog\Service\AbstractServiceManager
 */
class AbstractServiceManagerTest extends TestCase
{
    /** @var ServiceManagerStub */
    protected $service;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    /** @var \PHPUnit_Framework_MockObject_MockObject|MainConfig */
    protected $mockConfig;

    /** @var \PHPUnit_Framework_MockObject_MockObject|MapperInterface */
    protected $mockMapper;

    /** @var \PHPUnit_Framework_MockObject_MockObject|HandlerConfig */
    protected $mockHandlerConfig;

    public function setup()
    {
        $this->mockContainer = $this->createMock(ContainerInterface::class);

        $this->mockConfig = $this->getMockBuilder(MainConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockHandlerConfig = $this->getMockBuilder(HandlerConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockMapper = $this->createMock(MapperInterface::class);

        $this->service = new ServiceManagerStub(
            $this->mockConfig,
            $this->mockMapper,
            $this->mockContainer
        );

        $this->assertInstanceOf(AbstractServiceManager::class, $this->service);
    }

    public function testConstructor()
    {
    }

    public function testHasServiceFromContainer()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with('my-service')
            ->willReturn(true);

        $result = $this->service->has('my-service');
        $this->assertTrue($result);
    }

    public function testHasServiceFromConfig()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with('my-service')
            ->willReturn(false);

        $this->service->setHasServiceConfig(true);

        $result = $this->service->has('my-service');
        $this->assertTrue($result);
    }





    public function testGetServiceFromContainer()
    {
        $expected = $this->getMockBuilder(HandlerStub::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockContainer->expects($this->exactly(2))
            ->method('has')
            ->with('my-service')
            ->willReturn(true);

        $this->mockContainer->expects($this->exactly(1))
            ->method('get')
            ->with('my-service')
            ->willReturn($expected);

        $this->mockHandlerConfig->expects($this->never())
            ->method('getType');

        $this->mockHandlerConfig->expects($this->never())
            ->method('getOptions');

        $this->mockMapper->expects($this->never())
            ->method('map');

        $result = $this->service->get('my-service');
        $this->assertEquals($expected, $result);
    }

    public function testGetServiceFromFactoryClass()
    {
        $this->mockContainer->expects($this->exactly(2))
            ->method('has')
            ->with(FactoryStub::class)
            ->willReturn(false);

        $this->mockHandlerConfig->expects($this->once())
            ->method('getType')
            ->willReturn(FactoryStub::class);

        $this->mockHandlerConfig->expects($this->once())
            ->method('getOptions')
            ->willReturn([]);

        $this->mockMapper->expects($this->never())
            ->method('map');

        $this->service->setServiceConfig($this->mockHandlerConfig);
        $this->service->setHasServiceConfig(true);

        $result = $this->service->get(FactoryStub::class);
        $this->assertInstanceOf(HandlerStub::class, $result);
    }

    public function testGetServiceFromMapper()
    {
        $this->mockContainer->expects($this->exactly(2))
            ->method('has')
            ->with('my-service')
            ->willReturn(false);

        $this->mockHandlerConfig->expects($this->once())
            ->method('getType')
            ->willReturn('my-service');

        $this->mockHandlerConfig->expects($this->once())
            ->method('getOptions')
            ->willReturn([]);

        $this->mockMapper->expects($this->once())
            ->method('map')
            ->with('my-service')
            ->willReturn(FactoryStub::class);

        $this->service->setServiceConfig($this->mockHandlerConfig);
        $this->service->setHasServiceConfig(true);

        $result = $this->service->get('my-service');
        $this->assertInstanceOf(HandlerStub::class, $result);
    }

    public function testGetPreviouslyConstructedService()
    {
        $expected = $this->getMockBuilder(HandlerStub::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockContainer->expects($this->exactly(2))
            ->method('has')
            ->with('my-service')
            ->willReturn(true);

        $this->mockContainer->expects($this->exactly(1))
            ->method('get')
            ->with('my-service')
            ->willReturn($expected);

        $this->mockHandlerConfig->expects($this->never())
            ->method('getType');

        $this->mockHandlerConfig->expects($this->never())
            ->method('getOptions');

        $this->mockMapper->expects($this->never())
            ->method('map');

        $result = $this->service->get('my-service');
        $this->assertEquals($expected, $result);

        // No additional dependency calls should be made now
        $result = $this->service->has('my-service');
        $this->assertTrue($result);

        $result = $this->service->get('my-service');
        $this->assertEquals($expected, $result);
    }

    /** @expectedException \WShafer\PSR11MonoLog\Exception\UnknownServiceException */
    public function testGetServiceNotFound()
    {
        $this->mockContainer->expects($this->exactly(1))
            ->method('has')
            ->with('my-service')
            ->willReturn(false);

        $this->mockHandlerConfig->expects($this->never())
            ->method('getType');

        $this->mockHandlerConfig->expects($this->never())
            ->method('getOptions');

        $this->mockMapper->expects($this->never())
            ->method('map');

        $this->service->setServiceConfig($this->mockHandlerConfig);
        $this->service->setHasServiceConfig(false);

        $this->service->get('my-service');
    }

    /** @expectedException \WShafer\PSR11MonoLog\Exception\InvalidConfigException */
    public function testGetServiceInvalidFactory()
    {
        $this->mockContainer->expects($this->exactly(2))
            ->method('has')
            ->with('my-service')
            ->willReturn(false);

        $this->mockHandlerConfig->expects($this->once())
            ->method('getType')
            ->willReturn('my-service');

        $this->mockHandlerConfig->expects($this->once())
            ->method('getOptions')
            ->willReturn([]);

        $this->mockMapper->expects($this->once())
            ->method('map')
            ->with('my-service')
            ->willReturn(null);

        $this->service->setServiceConfig($this->mockHandlerConfig);
        $this->service->setHasServiceConfig(true);

        $this->service->get('my-service');
    }
}
