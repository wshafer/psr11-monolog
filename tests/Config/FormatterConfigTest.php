<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Config\FormatterConfig;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;

/**
 * @covers \WShafer\PSR11MonoLog\Config\FormatterConfig
 * @covers \WShafer\PSR11MonoLog\Config\AbstractServiceConfig
 */
class FormatterConfigTest extends TestCase
{
    /** @var FormatterConfig */
    protected $config;

    protected function getConfigArray()
    {
        return [
            'type' => 'LineFormatter',
            'options' => [
                'format' => "%datetime% > %level_name% > %message% %context% %extra%\n",
                'dateFormat' => 'Y n j, g:i a',
            ],
        ];
    }

    protected function setup(): void
    {
        $this->config = new FormatterConfig($this->getConfigArray());

        $this->assertInstanceOf(FormatterConfig::class, $this->config);
    }

    public function testConstructor()
    {
    }

    public function testConstructorMissingConfig()
    {
        $this->expectException(MissingConfigException::class);
        new FormatterConfig([]);
    }

    public function testConstructorMissingType()
    {
        $this->expectException(MissingConfigException::class);

        $config = $this->getConfigArray();
        unset($config['type']);
        new FormatterConfig($config);
    }

    public function testConstructorMissingOptions()
    {
        $config = $this->getConfigArray();
        unset($config['options']);

        $configService = new FormatterConfig($config);
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
