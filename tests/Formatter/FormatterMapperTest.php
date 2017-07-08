<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Formatter;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Formatter\ChromePHPFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\ElasticaFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\FlowdockFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\FormatterMapper;
use WShafer\PSR11MonoLog\Formatter\GelfMessageFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\HtmlFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\JsonFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\LineFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\LogglyFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\LogstashFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\MongoDBFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\NormalizerFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\ScalarFormatterFactory;
use WShafer\PSR11MonoLog\Formatter\WildfireFormatterFactory;

class FormatterMapperTest extends TestCase
{
    /** @var FormatterMapper */
    protected $mapper;

    public function setup()
    {
        $this->mapper = new FormatterMapper();
    }

    public function testMapLine()
    {
        $expected = LineFormatterFactory::class;
        $result = $this->mapper->map('line');
        $this->assertEquals($expected, $result);
    }

    public function testMapHtml()
    {
        $expected = HtmlFormatterFactory::class;
        $result = $this->mapper->map('html');
        $this->assertEquals($expected, $result);
    }

    public function testMapNormalizer()
    {
        $expected = NormalizerFormatterFactory::class;
        $result = $this->mapper->map('normalizer');
        $this->assertEquals($expected, $result);
    }

    public function testMapScalar()
    {
        $expected = ScalarFormatterFactory::class;
        $result = $this->mapper->map('scalar');
        $this->assertEquals($expected, $result);
    }

    public function testMapJson()
    {
        $expected = JsonFormatterFactory::class;
        $result = $this->mapper->map('json');
        $this->assertEquals($expected, $result);
    }

    public function testMapWildfire()
    {
        $expected = WildfireFormatterFactory::class;
        $result = $this->mapper->map('wildfire');
        $this->assertEquals($expected, $result);
    }

    public function testMapChromePHP()
    {
        $expected = ChromePHPFormatterFactory::class;
        $result = $this->mapper->map('chromePHP');
        $this->assertEquals($expected, $result);
    }

    public function testMapGelf()
    {
        $expected = GelfMessageFormatterFactory::class;
        $result = $this->mapper->map('gelf');
        $this->assertEquals($expected, $result);
    }

    public function testMapLogStash()
    {
        $expected = LogstashFormatterFactory::class;
        $result = $this->mapper->map('logstash');
        $this->assertEquals($expected, $result);
    }

    public function testMapElastica()
    {
        $expected = ElasticaFormatterFactory::class;
        $result = $this->mapper->map('elastica');
        $this->assertEquals($expected, $result);
    }

    public function testMapLoggly()
    {
        $expected = LogglyFormatterFactory::class;
        $result = $this->mapper->map('loggly');
        $this->assertEquals($expected, $result);
    }

    public function testMapFlowdock()
    {
        $expected = FlowdockFormatterFactory::class;
        $result = $this->mapper->map('flowdock');
        $this->assertEquals($expected, $result);
    }

    public function testMapMongoDb()
    {
        $expected = MongoDBFormatterFactory::class;
        $result = $this->mapper->map('mongodb');
        $this->assertEquals($expected, $result);
    }

    public function testMapNotFound()
    {
        $result = $this->mapper->map('notHere');
        $this->assertNull($result);
    }
}
