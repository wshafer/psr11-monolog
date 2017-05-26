<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Formatter\ElasticaFormatter;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\ElasticaFormatterFactory;

class ElasticaFormatterFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'index' => "my-index",
            'type'  => "doc-type"
        ];

        $factory = new ElasticaFormatterFactory();
        $formatter = $factory($options);

        $this->assertInstanceOf(ElasticaFormatter::class, $formatter);
    }
}
