<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use PHPUnit\Framework\TestCase;

use WShafer\PSR11MonoLog\Processor\IntrospectionProcessorFactory;
use WShafer\PSR11MonoLog\Processor\ProcessorMapper;
use WShafer\PSR11MonoLog\Processor\PsrLogMessageProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\ProcessorMapper
 */
class ProcessorMapperTest extends TestCase
{
    /** @var ProcessorMapper */
    protected $mapper;

    public function setup()
    {
        $this->mapper = new ProcessorMapper();
    }

    public function testPsrLogMessage()
    {
        $expected = PsrLogMessageProcessorFactory::class;
        $result = $this->mapper->map('psrLogMessage');
        $this->assertEquals($expected, $result);
    }

    public function testIntrospection()
    {
        $expected = IntrospectionProcessorFactory::class;
        $result = $this->mapper->map('introspection');
        $this->assertEquals($expected, $result);
    }

    public function testMapNotFound()
    {
        $result = $this->mapper->map('notHere');
        $this->assertNull($result);
    }
}
