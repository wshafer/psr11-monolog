<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\ChannelChanger;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\ChannelChangerFactory;
use WShafer\PSR11MonoLog\Service\FormatterManager;
use WShafer\PSR11MonoLog\Service\HandlerManager;
use WShafer\PSR11MonoLog\Service\ProcessorManager;

/**
 * @covers \WShafer\PSR11MonoLog\ChannelChangerFactory
 */
class ChannelChangerFactoryTest extends TestCase
{
    use ConfigTrait;

    /** @var ChannelChangerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new ChannelChangerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $config = $this->getConfigArray();

        $this->mockContainer->expects($this->any())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->mockContainer->expects($this->any())
            ->method('get')
            ->with('config')
            ->willReturn($config);
    }

    public function testGetMainConfig()
    {
        $config = $this->factory->getMainConfig($this->mockContainer);
        $this->assertInstanceOf(MainConfig::class, $config);
    }

    public function testGetFormatterManager()
    {
        $manager = $this->factory->getFormatterManager($this->mockContainer);
        $this->assertInstanceOf(FormatterManager::class, $manager);
    }

    public function testGetProcessorManager()
    {
        $manager = $this->factory->getProcessorManager($this->mockContainer);
        $this->assertInstanceOf(ProcessorManager::class, $manager);
    }

    public function testGetHandlerManager()
    {
        $manager = $this->factory->getHandlerManager($this->mockContainer);
        $this->assertInstanceOf(HandlerManager::class, $manager);
    }

    public function testInvoke()
    {
        $manager = $this->factory->__invoke($this->mockContainer);
        $this->assertInstanceOf(ChannelChanger::class, $manager);
    }
}
