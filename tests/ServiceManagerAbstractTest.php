<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Exception\InvalidConfigException;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceManagerAbstract;
use WShafer\PSR11MonoLog\MapperInterface;
use WShafer\PSR11MonoLog\Test\Stub\FactoryStub;
use WShafer\PSR11MonoLog\Test\Stub\MapperStub;

class ServiceManagerAbstractTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockMapper;

    /** @var ServiceManagerAbstract */
    protected $serviceManagerAbstract;

    public function setup()
    {
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->mockMapper = $this->createMock(MapperInterface::class);

        $this->serviceManagerAbstract = $this->getMockForAbstractClass(
            ServiceManagerAbstract::class,
            [$this->mockContainer, $this->mockMapper]
        );

        $this->assertInstanceOf(ServiceManagerAbstract::class, $this->serviceManagerAbstract);
    }

    public function testConstructor()
    {
    }

    public function testGetHasService()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with('service')
            ->willReturn(true);

        $service = new \stdClass();
        $service->dummyData = true;

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with('service')
            ->willReturn($service);

        $result = $this->serviceManagerAbstract->get('service', []);
        $this->assertEquals($service, $result);
    }

    public function testGetHasFactoryClass()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with(FactoryStub::class)
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get')
            ->with('service');

        $options = [
            'test' => true
        ];

        $result = $this->serviceManagerAbstract->get(FactoryStub::class, $options);
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertTrue($result->test);
    }

    public function testGetMissingFactory()
    {
        $this->expectException(InvalidConfigException::class);
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with('doesNotExist')
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get')
            ->with('service');

        $options = [
            'test' => true
        ];

        $this->serviceManagerAbstract->get('doesNotExist', $options);
    }

    public function testGetUsingMapper()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with('FactoryStub')
            ->willReturn(false);

        $this->mockMapper->expects($this->once())
            ->method('map')
            ->willReturn(FactoryStub::class);

        $options = [
            'test' => true
        ];

        $result = $this->serviceManagerAbstract->get('FactoryStub', $options);

        $this->assertInstanceOf(\stdClass::class, $result);
    }

    public function testGetClassNotFound()
    {
        $this->expectException(InvalidConfigException::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with(\stdClass::class)
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get')
            ->with('service');

        $options = [
            'test' => true
        ];

        $this->serviceManagerAbstract->get(\stdClass::class, $options);
    }

    public function testGetWithInvalidFactory()
    {
        $this->expectException(InvalidConfigException::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with(\stdClass::class)
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get')
            ->with('service');

        $this->mockMapper->expects($this->once())
            ->method('map')
            ->willReturn(\stdClass::class);

        $options = [
            'test' => true
        ];

        $this->serviceManagerAbstract->get(\stdClass::class, $options);
    }

    public function testHasWithService()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with('service')
            ->willReturn(true);

        $this->assertTrue($this->serviceManagerAbstract->has('service'));
    }

    public function testHasWithFactoryClass()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with(FactoryStub::class)
            ->willReturn(false);

        $this->assertTrue($this->serviceManagerAbstract->has(FactoryStub::class));
    }

    public function testHasUsingMapper()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with(\stdClass::class)
            ->willReturn(false);

        $this->mockMapper->expects($this->once())
            ->method('map')
            ->willReturn(FactoryStub::class);

        $this->assertTrue($this->serviceManagerAbstract->has(\stdClass::class));
    }

    public function testHasNotFound()
    {
        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with('notHere')
            ->willReturn(false);

        $this->assertFalse($this->serviceManagerAbstract->has('notHere'));
    }
}
