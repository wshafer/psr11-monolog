<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Processor\UidProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\UidProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\UidProcessorFactory
 */
class UidProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = ['length' => 7];

        $factory = new UidProcessorFactory();
        $handler = $factory($options);
        $this->assertInstanceOf(UidProcessor::class, $handler);
    }
}
