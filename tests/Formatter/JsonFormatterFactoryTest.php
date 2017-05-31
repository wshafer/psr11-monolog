<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Formatter;

use Monolog\Formatter\JsonFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\JsonFormatterFactory;

class JsonFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'batchMode' => JsonFormatter::BATCH_MODE_NEWLINES,
            'appendNewline' => false,
        ];

        $factory = new JsonFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(JsonFormatter::class, $formatter);
    }
}
