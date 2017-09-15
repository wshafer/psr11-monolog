<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\Service\HandlerManager;

/**
 * @covers \WShafer\PSR11MonoLog\HandlerManagerTrait
 */
class HandlerManagerTraitTest extends TestCase
{
    public function testGetSetHandlerManager()
    {
        $mockManager = $this->getMockBuilder(HandlerManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var HandlerManagerTrait $trait */
        $trait = $this->getMockForTrait(HandlerManagerTrait::class);
        $trait->setHandlerManager($mockManager);
        $container = $trait->getHandlerManager();

        $this->assertEquals($mockManager, $container);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testGetHandlerManagerNoManagerSet()
    {
        /** @var HandlerManagerTrait $trait */
        $trait = $this->getMockForTrait(HandlerManagerTrait::class);
        $trait->getHandlerManager();
    }
}
