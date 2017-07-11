<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Formatter;

use Monolog\Formatter\LogstashFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\LogstashFormatterFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Formatter\LogstashFormatterFactory
 */
class LogstashFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'applicationName' => "my-app",
            'systemName'      => "my-name",
            'extraPrefix'     => 'extraPrefix_',
            'contextPrefix'   => 'contextPrefix_'
        ];

        $factory = new LogstashFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(LogstashFormatter::class, $formatter);
    }
}
