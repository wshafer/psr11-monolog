<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Formatter\NormalizerFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\NormalizerFormatterFactory;

class NormalizerFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = ['dateFormat' => 'c'];
        $factory = new NormalizerFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(NormalizerFormatter::class, $formatter);
    }
}
