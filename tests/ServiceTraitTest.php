<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\ServiceTrait;
use stdClass;

/**
 * @covers \WShafer\PSR11MonoLog\ServiceTrait
 */
class ServiceTraitTest extends TestCase
{
    /** @var ServiceTrait */
    protected $trait;

    /** @var MockObject|ContainerInterface */
    protected $mockContainer;

    protected function setup(): void
    {
        $this->trait = $this->getMockForTrait(ServiceTrait::class);
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->trait->setContainer($this->mockContainer);
    }

    public function testGetClient()
    {
        $service = 'my-service';

        $mockService = new stdClass();

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

    public function testGetClientMissingService()
    {
        $this->expectException(MissingServiceException::class);

        $service = 'my-service';

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->trait->getService($service);
    }

    public function testGetClientMissingConfig()
    {
        $this->expectException(MissingConfigException::class);
        $service = null;

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->trait->getService($service);
    }
}
