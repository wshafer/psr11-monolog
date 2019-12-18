<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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

    /** @var MockObject|ContainerInterface */
    protected $mockContainer;

    protected function setup(): void
    {
        $this->factory = new ChannelChangerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
    }

    public function testGetMainConfig()
    {
        $configArray = $this->getConfigArray();

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn($configArray);

        $config = $this->factory->getMainConfig($this->mockContainer);
        $this->assertInstanceOf(MainConfig::class, $config);
    }

    public function testGetMainConfigUsingParameters()
    {
        $configArray = $this->getConfigArray();

        $this->mockContainer = $this->createMock(ContainerBuilder::class);

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->once())
            ->method('hasParameter')
            ->with('monolog')
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('getParameter')
            ->with('monolog')
            ->willReturn($configArray['monolog']);

        $config = $this->factory->getMainConfig($this->mockContainer);
        $this->assertInstanceOf(MainConfig::class, $config);
    }

    public function testGetMainConfigUsingSettings()
    {
        $configArray = $this->getConfigArray();

        $map = [
            ['config', false],
            ['settings', true],
        ];

        $this->mockContainer->expects($this->exactly(2))
            ->method('has')
            ->will($this->returnValueMap($map));

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with('settings')
            ->willReturn($configArray);

        $config = $this->factory->getMainConfig($this->mockContainer);
        $this->assertInstanceOf(MainConfig::class, $config);
    }

    public function testGetFormatterManager()
    {
        $configArray = $this->getConfigArray();

        $this->mockContainer->expects($this->any())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->mockContainer->expects($this->any())
            ->method('get')
            ->with('config')
            ->willReturn($configArray);

        $manager = $this->factory->getFormatterManager($this->mockContainer);
        $this->assertInstanceOf(FormatterManager::class, $manager);
    }

    public function testGetProcessorManager()
    {
        $configArray = $this->getConfigArray();

        $this->mockContainer->expects($this->any())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->mockContainer->expects($this->any())
            ->method('get')
            ->with('config')
            ->willReturn($configArray);

        $manager = $this->factory->getProcessorManager($this->mockContainer);
        $this->assertInstanceOf(ProcessorManager::class, $manager);
    }

    public function testGetHandlerManager()
    {
        $configArray = $this->getConfigArray();

        $this->mockContainer->expects($this->any())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->mockContainer->expects($this->any())
            ->method('get')
            ->with('config')
            ->willReturn($configArray);

        $manager = $this->factory->getHandlerManager($this->mockContainer);
        $this->assertInstanceOf(HandlerManager::class, $manager);
    }

    public function testInvoke()
    {
        $configArray = $this->getConfigArray();

        $this->mockContainer->expects($this->any())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->mockContainer->expects($this->any())
            ->method('get')
            ->with('config')
            ->willReturn($configArray);

        $manager = $this->factory->__invoke($this->mockContainer);
        $this->assertInstanceOf(ChannelChanger::class, $manager);
    }
}
