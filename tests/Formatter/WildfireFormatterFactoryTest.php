<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Formatter;

use Monolog\Formatter\WildfireFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\WildfireFormatterFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Formatter\WildfireFormatterFactory
 */
class WildfireFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = ['dateFormat' => 'c'];
        $factory = new WildfireFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(WildfireFormatter::class, $formatter);
    }
}
