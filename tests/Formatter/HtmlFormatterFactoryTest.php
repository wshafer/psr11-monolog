<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Formatter\HtmlFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\HtmlFormatterFactory;

class HtmlFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = ['dateFormat' => 'c'];
        $factory = new HtmlFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(HtmlFormatter::class, $formatter);
    }
}
