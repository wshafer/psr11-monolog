<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Processor\MemoryUsageProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\MemoryUsageProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\MemoryUsageProcessorFactory
 */
class MemoryUsageProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $factory = new MemoryUsageProcessorFactory();
        $handler = $factory([]);
        $this->assertInstanceOf(MemoryUsageProcessor::class, $handler);
    }
}
