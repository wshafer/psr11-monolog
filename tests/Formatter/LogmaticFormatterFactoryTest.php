<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Formatter;

use Monolog\Formatter\LogmaticFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\LogmaticFormatterFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Formatter\LogmaticFormatterFactory
 */
class LogmaticFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'batchMode' => LogmaticFormatter::BATCH_MODE_NEWLINES,
            'appendNewline' => false,
            'hostname' => 'my host',
            'appName' => 'my app',
        ];

        $factory = new LogmaticFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(LogmaticFormatter::class, $formatter);
    }
}
