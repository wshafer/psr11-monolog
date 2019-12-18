<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Formatter;

use Monolog\Formatter\FlowdockFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\FlowdockFormatterFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Formatter\FlowdockFormatterFactory
 */
class FlowdockFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'source'      => 'some-source',
            'sourceEmail' => 'some-email',
        ];

        $factory = new FlowdockFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(FlowdockFormatter::class, $formatter);
    }
}
