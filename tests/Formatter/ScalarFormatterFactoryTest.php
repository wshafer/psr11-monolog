<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Formatter\ScalarFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\ScalarFormatterFactory;

class ScalarFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [];
        $factory = new ScalarFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(ScalarFormatter::class, $formatter);
    }
}
