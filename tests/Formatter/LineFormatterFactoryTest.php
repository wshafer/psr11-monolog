<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Formatter\LineFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\LineFormatterFactory;

class LineFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'format'                     => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
            'dateFormat'                 => 'c',
            'allowInlineLineBreaks'      => true,
            'ignoreEmptyContextAndExtra' => true,
        ];

        $factory = new LineFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(LineFormatter::class, $formatter);
    }
}
