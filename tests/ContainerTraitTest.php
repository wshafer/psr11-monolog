<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\ContainerTrait;

/**
 * @covers \WShafer\PSR11MonoLog\ContainerTrait
 */
class ContainerTraitTest extends TestCase
{
    public function testGetSetContainer()
    {
        $mockContainer = $this->createMock(ContainerInterface::class);

        $trait = $this->getMockForTrait(ContainerTrait::class);
        $trait->setContainer($mockContainer);
        $container = $trait->getContainer();

        $this->assertEquals($mockContainer, $container);
    }
}
