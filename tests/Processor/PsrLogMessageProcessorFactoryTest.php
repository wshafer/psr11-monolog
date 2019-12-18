<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Processor\PsrLogMessageProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\PsrLogMessageProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\PsrLogMessageProcessorFactory
 */
class PsrLogMessageProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $factory = new PsrLogMessageProcessorFactory();
        $handler = $factory([]);
        $this->assertInstanceOf(PsrLogMessageProcessor::class, $handler);
    }
}
