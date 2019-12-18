<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Processor\HostnameProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\HostnameProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\HostnameProcessorFactory
 */
class HostnameProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $factory = new HostnameProcessorFactory();
        $handler = $factory([]);
        $this->assertInstanceOf(HostnameProcessor::class, $handler);
    }
}
