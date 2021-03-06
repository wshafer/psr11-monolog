<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\Service\HandlerManager;

/**
 * @covers \WShafer\PSR11MonoLog\HandlerManagerTrait
 */
class HandlerManagerTraitTest extends TestCase
{
    public function testGetSetHandlerManager()
    {
        /** @var HandlerManager $mockManager */
        $mockManager = $this->getMockBuilder(HandlerManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var HandlerManagerTrait $trait */
        $trait = $this->getMockForTrait(HandlerManagerTrait::class);
        $trait->setHandlerManager($mockManager);
        $container = $trait->getHandlerManager();

        $this->assertEquals($mockManager, $container);
    }

    public function testGetHandlerManagerNoManagerSet()
    {
        $this->expectException(MissingServiceException::class);

        /** @var HandlerManagerTrait $trait */
        $trait = $this->getMockForTrait(HandlerManagerTrait::class);
        $trait->getHandlerManager();
    }
}
