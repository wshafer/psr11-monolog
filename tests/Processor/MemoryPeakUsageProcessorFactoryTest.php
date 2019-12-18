<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Processor\MemoryPeakUsageProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\MemoryPeakUsageProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\MemoryPeakUsageProcessorFactory
 */
class MemoryPeakUsageProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $factory = new MemoryPeakUsageProcessorFactory();
        $handler = $factory([]);
        $this->assertInstanceOf(MemoryPeakUsageProcessor::class, $handler);
    }
}
