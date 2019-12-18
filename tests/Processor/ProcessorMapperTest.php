<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use PHPUnit\Framework\TestCase;

use WShafer\PSR11MonoLog\Processor\GitProcessorFactory;
use WShafer\PSR11MonoLog\Processor\HostnameProcessorFactory;
use WShafer\PSR11MonoLog\Processor\IntrospectionProcessorFactory;
use WShafer\PSR11MonoLog\Processor\MemoryPeakUsageProcessorFactory;
use WShafer\PSR11MonoLog\Processor\MemoryUsageProcessorFactory;
use WShafer\PSR11MonoLog\Processor\MercurialProcessorFactory;
use WShafer\PSR11MonoLog\Processor\ProcessIdProcessorFactory;
use WShafer\PSR11MonoLog\Processor\ProcessorMapper;
use WShafer\PSR11MonoLog\Processor\PsrLogMessageProcessorFactory;
use WShafer\PSR11MonoLog\Processor\TagProcessorFactory;
use WShafer\PSR11MonoLog\Processor\UidProcessorFactory;
use WShafer\PSR11MonoLog\Processor\WebProcessorFactory;

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

    public function testMapPsrLogMessage()
    {
        $expected = PsrLogMessageProcessorFactory::class;
        $result = $this->mapper->map('psrLogMessage');
        $this->assertEquals($expected, $result);
    }

    public function testMapIntrospection()
    {
        $expected = IntrospectionProcessorFactory::class;
        $result = $this->mapper->map('introspection');
        $this->assertEquals($expected, $result);
    }

    public function testMapWebProcessor()
    {
        $expected = WebProcessorFactory::class;
        $result = $this->mapper->map('web');
        $this->assertEquals($expected, $result);
    }

    public function testMapMemoryUsageProcessor()
    {
        $expected = MemoryUsageProcessorFactory::class;
        $result = $this->mapper->map('memoryUsage');
        $this->assertEquals($expected, $result);
    }

    public function testMapMemoryUsageProcessId()
    {
        $expected = ProcessIdProcessorFactory::class;
        $result = $this->mapper->map('processid');
        $this->assertEquals($expected, $result);
    }

    public function testMapMemoryPeakProcessor()
    {
        $expected = MemoryPeakUsageProcessorFactory::class;
        $result = $this->mapper->map('memoryPeak');
        $this->assertEquals($expected, $result);
    }

    public function testMapUidProcessor()
    {
        $expected = UidProcessorFactory::class;
        $result = $this->mapper->map('uid');
        $this->assertEquals($expected, $result);
    }

    public function testGitProcessor()
    {
        $expected = GitProcessorFactory::class;
        $result = $this->mapper->map('git');
        $this->assertEquals($expected, $result);
    }

    public function testMercurialProcessor()
    {
        $expected = MercurialProcessorFactory::class;
        $result = $this->mapper->map('mercurial');
        $this->assertEquals($expected, $result);
    }

    public function testTagProcessor()
    {
        $expected = TagProcessorFactory::class;
        $result = $this->mapper->map('tags');
        $this->assertEquals($expected, $result);
    }

    public function testHostnameProcessor()
    {
        $expected = HostnameProcessorFactory::class;
        $result = $this->mapper->map('hostname');
        $this->assertEquals($expected, $result);
    }

    public function testMapNotFound()
    {
        $result = $this->mapper->map('notHere');
        $this->assertNull($result);
    }
}
