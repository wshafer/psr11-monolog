<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Config\HandlerConfig;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;

/**
 * @covers \WShafer\PSR11MonoLog\Config\HandlerConfig
 * @covers \WShafer\PSR11MonoLog\Config\AbstractServiceConfig
 */
class HandlerConfigTest extends TestCase
{
    /** @var HandlerConfig */
    protected $config;

    protected function getConfigArray()
    {
        return [
            'type' => 'StreamHandler',
            'formatter' => 'formatterOne',
            'options' => [
                'stream' => '/tmp/logOne.txt',
                'level' => Logger::ERROR,
                'bubble' =>  true,
                'filePermission' => 755,
                'useLocking' => true
            ],
            'processors' => [
                'processorOne',
                'processorTwo',
            ]
        ];
    }

    protected function setup(): void
    {
        $this->config = new HandlerConfig($this->getConfigArray());

        $this->assertInstanceOf(HandlerConfig::class, $this->config);
    }

    public function testConstructor()
    {
    }

    public function testConstructorMissingConfig()
    {
        $this->expectException(MissingConfigException::class);
        new HandlerConfig([]);
    }

    public function testConstructorMissingType()
    {
        $this->expectException(MissingConfigException::class);

        $config = $this->getConfigArray();
        unset($config['type']);
        new HandlerConfig($config);
    }

    public function testConstructorMissingOptions()
    {
        $config = $this->getConfigArray();
        unset($config['options']);

        $configService = new HandlerConfig($config);
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

    public function testGetFormatter()
    {
        $config = $this->getConfigArray();
        $formatter = $this->config->getFormatter();
        $this->assertEquals($config['formatter'], $formatter);
    }

    public function testGetFormatterMissingFormatter()
    {
        $config = $this->getConfigArray();
        unset($config['formatter']);
        $configService = new HandlerConfig($config);
        $formatter = $configService->getFormatter();
        $this->assertEmpty($formatter);
    }

    public function testGetProcessors()
    {
        $config = $this->getConfigArray();
        $processors = $this->config->getProcessors();
        $this->assertEquals($config['processors'], $processors);
    }
}
