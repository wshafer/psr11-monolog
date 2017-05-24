<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Config\ChannelConfig;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;

/**
 * @covers \WShafer\PSR11MonoLog\Config\ChannelConfig
 */
class ChannelConfigTest extends TestCase
{
    /** @var ChannelConfig */
    protected $config;

    protected function getConfigArray()
    {
        return [
            'handlers' => [
                'handlerOne',
                'handlerTwo'
            ],

            'processors' => [
                'serviceOne',
                'serviceTwo'
            ],
        ];
    }

    public function setup()
    {
        $this->config = new ChannelConfig($this->getConfigArray());

        $this->assertInstanceOf(ChannelConfig::class, $this->config);
    }

    public function testConstructor()
    {
    }

    public function testConstructorMissingConfig()
    {
        $this->expectException(MissingConfigException::class);
        new ChannelConfig([]);
    }

    public function testConstructorMissingHandlers()
    {
        $this->expectException(MissingConfigException::class);
        $config = $this->getConfigArray();
        unset($config['handlers']);
        new ChannelConfig($config);
    }

    public function testConstructorMissingProcessors()
    {
        $config = $this->getConfigArray();
        unset($config['processors']);
        $configService = new ChannelConfig($config);
        $this->assertEmpty($configService->getProcessors());
    }

    public function testGetHandlers()
    {
        $config = $this->getConfigArray();
        $results = $this->config->getHandlers();
        $this->assertEquals($config['handlers'], $results);
    }

    public function testGetProcessors()
    {
        $config = $this->getConfigArray();
        $results = $this->config->getProcessors();
        $this->assertEquals($config['processors'], $results);
    }
}
