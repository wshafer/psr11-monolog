<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Config\FormatterConfig;
use WShafer\PSR11MonoLog\Config\ProcessorConfig;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;

/**
 * @covers \WShafer\PSR11MonoLog\Config\ProcessorConfig
 * @covers \WShafer\PSR11MonoLog\Config\AbstractServiceConfig
 */
class ProcessorConfigTest extends TestCase
{
    /** @var FormatterConfig */
    protected $config;

    protected function getConfigArray()
    {
        return [
            'type' => 'Processor',
            'options' => [
                'dateFormat' => 'Y n j, g:i a',
            ],
        ];
    }

    protected function setup(): void
    {
        $this->config = new ProcessorConfig($this->getConfigArray());

        $this->assertInstanceOf(ProcessorConfig::class, $this->config);
    }

    public function testConstructor()
    {
    }

    public function testConstructorMissingConfig()
    {
        $this->expectException(MissingConfigException::class);
        new ProcessorConfig([]);
    }

    public function testConstructorMissingType()
    {
        $this->expectException(MissingConfigException::class);

        $config = $this->getConfigArray();
        unset($config['type']);
        new ProcessorConfig($config);
    }

    public function testConstructorMissingOptions()
    {
        $config = $this->getConfigArray();
        unset($config['options']);

        $configService = new ProcessorConfig($config);
        $this->assertEmpty($configService->getOptions());
    }

    public function testGetType()
    {
        $config = $this->getConfigArray();
        $type = $this->config->getType();
        $this->assertEquals($config['type'], $type);
    }

    public function testGetOptions()
    {
        $config = $this->getConfigArray();
        $type = $this->config->getOptions();
        $this->assertEquals($config['options'], $type);
    }
}
