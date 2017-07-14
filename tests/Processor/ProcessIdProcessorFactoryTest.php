<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Processor\ProcessIdProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\ProcessIdProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\ProcessIdProcessorFactory
 */
class ProcessIdProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $factory = new ProcessIdProcessorFactory();
        $handler = $factory([]);
        $this->assertInstanceOf(ProcessIdProcessor::class, $handler);
    }
}
