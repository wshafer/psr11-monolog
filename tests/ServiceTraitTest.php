<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

/**
 * @covers \WShafer\PSR11MonoLog\ServiceTrait
 */
class ServiceTraitTest extends TestCase
{
    /** @var ServiceTrait */
    protected $trait;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->trait = $this->getMockForTrait(ServiceTrait::class);
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->trait->setContainer($this->mockContainer);
    }

    public function testGetClient()
    {
        $service = 'my-service';

        $mockService = new \stdClass();

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $service = $this->trait->getService($service);
        $this->assertEquals($mockService, $service);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testGetClientMissingService()
    {
        $service = 'my-service';

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->trait->getService($service);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testGetClientMissingConfig()
    {
        $service = null;

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->trait->getService($service);
    }
}
