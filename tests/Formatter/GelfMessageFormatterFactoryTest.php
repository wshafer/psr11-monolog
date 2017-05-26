<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Formatter\GelfMessageFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\GelfMessageFormatterFactory;

class GelfMessageFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'systemName'    => "my-name",
            'extraPrefix'    => 'extraPrefix_',
            'contextPrefix' => 'contextPrefix_'
        ];

        $factory = new GelfMessageFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(GelfMessageFormatter::class, $formatter);
    }
}
