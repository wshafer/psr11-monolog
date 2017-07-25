<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\Config\MainConfigFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Config\MainConfigFactory
 */
class MainConfigFactoryTest extends TestCase
{
    use ConfigTrait;

    public function testInvoke()
    {
        $mockContainer = $this->createMock(ContainerInterface::class);
        $mockContainer->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn($this->getConfigArray());

        $mockContainer->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $factory = new MainConfigFactory();

        $this->assertInstanceOf(MainConfigFactory::class, $factory);

        $mainConfig = $factory($mockContainer);

        $this->assertInstanceOf(MainConfig::class, $mainConfig);
    }
}
