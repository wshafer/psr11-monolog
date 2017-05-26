<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
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
        $mockContainer = $this->createMock(ContainerInterface::class);
        $this->mapper = new FormatterMapper($mockContainer);
    }

    public function testGetFactoryClassNameFullClassName()
    {
        $expected = HtmlFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName($expected);
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameLine()
    {
        $expected = LineFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('line');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameHtml()
    {
        $expected = HtmlFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('html');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameNormalizer()
    {
        $expected = NormalizerFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('normalizer');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameScalar()
    {
        $expected = ScalarFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('scalar');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameJson()
    {
        $expected = JsonFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('json');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameWildfire()
    {
        $expected = WildfireFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('wildfire');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameChromePHP()
    {
        $expected = ChromePHPFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('chromePHP');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameGelf()
    {
        $expected = GelfMessageFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('gelf');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameLogStash()
    {
        $expected = LogstashFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('logstash');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameElastica()
    {
        $expected = ElasticaFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('elastica');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameLoggly()
    {
        $expected = LogglyFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('loggly');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameFlowdock()
    {
        $expected = FlowdockFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('flowdock');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameMongoDb()
    {
        $expected = MongoDBFormatterFactory::class;
        $result = $this->mapper->getFactoryClassName('mongodb');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameNotFound()
    {
        $result = $this->mapper->getFactoryClassName('notHere');
        $this->assertNull($result);
    }
}
