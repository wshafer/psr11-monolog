<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Formatter;

use Monolog\Formatter\ChromePHPFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\ChromePHPFormatterFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Formatter\ChromePHPFormatterFactory
 */
class ChromePHPFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [];
        $factory = new ChromePHPFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(ChromePHPFormatter::class, $formatter);
    }
}
