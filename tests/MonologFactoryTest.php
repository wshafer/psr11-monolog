<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\ChannelChanger;
use WShafer\PSR11MonoLog\MonologFactory;

class MonologFactoryTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|ChannelChanger */
    protected $mockChannelChanger;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    /** @var MonologFactory */
    protected $factory;

    public function setup()
    {
        $this->mockChannelChanger = $this->getMockBuilder(ChannelChanger::class)
            ->disableOriginalConstructor()
            ->getMock();

        MonologFactory::setChannelChanger($this->mockChannelChanger);

        $this->mockContainer = $this->createMock(ContainerInterface::class);

        $this->factory = new MonologFactory();

        $this->assertInstanceOf(MonologFactory::class, $this->factory);
    }

    public function testGetAndSetChannelChanger()
    {
        $result = MonologFactory::getChannelChanger($this->mockContainer);

        $this->assertEquals($this->mockChannelChanger, $result);
    }

    public function testInvoke()
    {
        $this->mockChannelChanger->expects($this->once())
            ->method('get')
            ->with('default')
            ->willReturn(true);

        $result = $this->factory->__invoke($this->mockContainer);

        $this->assertTrue($result);
    }

    public function testCallStatic()
    {
        $this->mockChannelChanger->expects($this->once())
            ->method('get')
            ->with('channelTwo')
            ->willReturn(true);

        $result = MonologFactory::__callStatic('channelTwo', [$this->mockContainer]);

        $this->assertTrue($result);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\InvalidContainerException
     */
    public function testCallStaticNoContainer()
    {
        $this->mockChannelChanger->expects($this->never())
            ->method('get');

        MonologFactory::__callStatic('channelTwo', []);
    }
}
