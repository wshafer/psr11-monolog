<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\ClientTrait;

/**
 * @covers \WShafer\PSR11MonoLog\ClientTrait
 */
class ClientTraitTest extends TestCase
{
    /** @var ClientTrait */
    protected $trait;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->trait = $this->getMockForTrait(ClientTrait::class);
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->trait->setContainer($this->mockContainer);
    }

    public function testGetClient()
    {
        $options = [
            'client' => 'my-service',
        ];

        $mockService = new \stdClass();

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $service = $this->trait->getClient($options);
        $this->assertEquals($mockService, $service);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testGetClientMissingService()
    {
        $options = [
            'client' => 'my-service',
        ];

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->trait->getClient($options);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testGetClientMissingConfig()
    {
        $options = [];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $this->trait->getClient($options);
    }
}
