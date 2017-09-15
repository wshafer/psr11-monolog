<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Config\ChannelConfig;
use WShafer\PSR11MonoLog\Config\FormatterConfig;
use WShafer\PSR11MonoLog\Config\HandlerConfig;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\Config\ProcessorConfig;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;

/**
 * @covers \WShafer\PSR11MonoLog\Config\MainConfig
 */
class MainConfigTest extends TestCase
{
    /** @var MainConfig */
    protected $config;

    use ConfigTrait;

    public function setup()
    {
        $this->config = new MainConfig($this->getConfigArray());

        $this->assertInstanceOf(MainConfig::class, $this->config);
    }

    public function testConstructor()
    {
    }

    public function testConstructorMissingFormatterConfig()
    {
        $config = $this->getConfigArray();
        unset($config['monolog']['formatters']);

        $configService = new MainConfig($config);
        $this->assertEmpty($configService->getFormatters());
    }

    public function testGetHandlers()
    {
        $config = $this->getConfigArray();

        $handlerConfigs = $this->config->getHandlers();
        $expectedCount = count($config['monolog']['handlers']);
        $this->assertCount($expectedCount, $handlerConfigs);

        foreach ($handlerConfigs as $handlerConfig) {
            $this->assertInstanceOf(HandlerConfig::class, $handlerConfig);
        }
    }

    public function testHasHandlerConfig()
    {
        $result = $this->config->hasHandlerConfig('default');
        $this->assertTrue($result);
    }

    public function testGetHandlerConfig()
    {
        $config = $this->getConfigArray();
        $expected = $config['monolog']['handlers']['default']['type'];
        $result = $this->config->getHandlerConfig('default');

        $this->assertInstanceOf(HandlerConfig::class, $result);
        $this->assertEquals($expected, $result->getType());
    }

    public function testGetFormatters()
    {
        $config = $this->getConfigArray();

        $formatterConfigs = $this->config->getFormatters();
        $expectedCount = count($config['monolog']['formatters']);
        $this->assertCount($expectedCount, $formatterConfigs);

        foreach ($formatterConfigs as $formatterConfig) {
            $this->assertInstanceOf(FormatterConfig::class, $formatterConfig);
        }
    }

    public function testHasFormatterConfig()
    {
        $result = $this->config->hasFormatterConfig('formatterOne');
        $this->assertTrue($result);
    }

    public function testGetFormatterConfig()
    {
        $config = $this->getConfigArray();
        $expected = $config['monolog']['formatters']['formatterOne']['type'];
        $result = $this->config->getFormatterConfig('formatterOne');

        $this->assertInstanceOf(FormatterConfig::class, $result);
        $this->assertEquals($expected, $result->getType());
    }

    public function testGetProcessors()
    {
        $config = $this->getConfigArray();

        $processorConfigs = $this->config->getProcessors();
        $expectedCount = count($config['monolog']['processors']);
        $this->assertCount($expectedCount, $processorConfigs);

        foreach ($processorConfigs as $processorConfig) {
            $this->assertInstanceOf(ProcessorConfig::class, $processorConfig);
        }
    }

    public function testGetProcessorsNoneConfigured()
    {
        $config = $this->getConfigArray();
        unset($config['monolog']['processors']);

        $this->config = new MainConfig($config);
        $processorConfigs = $this->config->getProcessors();
        $this->assertEmpty($processorConfigs);
    }

    public function testHasProcessorConfig()
    {
        $result = $this->config->hasProcessorConfig('processorOne');
        $this->assertTrue($result);
    }

    public function testGetProcessorConfig()
    {
        $config = $this->getConfigArray();
        $expected = $config['monolog']['processors']['processorOne']['type'];
        $result = $this->config->getProcessorConfig('processorOne');

        $this->assertInstanceOf(ProcessorConfig::class, $result);
        $this->assertEquals($expected, $result->getType());
    }

    public function testGetChannels()
    {
        $config = $this->getConfigArray();

        $channelConfigs = $this->config->getChannels();
        $expectedCount = count($config['monolog']['channels']);
        $this->assertCount($expectedCount, $channelConfigs);

        foreach ($channelConfigs as $channelConfig) {
            $this->assertInstanceOf(ChannelConfig::class, $channelConfig);
        }
    }

    public function testHasChannelConfig()
    {
        $result = $this->config->hasChannelConfig('default');
        $this->assertTrue($result);
    }

    public function testGetChannelConfig()
    {
        $config = $this->getConfigArray();
        $expected = $config['monolog']['channels']['default']['handlers'];
        $result = $this->config->getChannelConfig('default');

        $this->assertInstanceOf(ChannelConfig::class, $result);
        $this->assertEquals($expected, $result->getHandlers());
    }

    public function testSetChannelConfigDefaults()
    {
        $config = $this->getConfigArray();
        unset($config['monolog']['channels']);

        $this->config = new MainConfig($config);
        $result = $this->config->getChannelConfig('default');

        $this->assertInstanceOf(ChannelConfig::class, $result);

        $expectedHandlers = ['default'];

        $handlers = $result->getHandlers();

        $this->assertEquals($expectedHandlers, $handlers);
    }

    public function testSetHandlerConfigDefaults()
    {
        $config = $this->getConfigArray();
        unset($config['monolog']['handlers']);

        $this->config = new MainConfig($config);
        $result = $this->config->getHandlerConfig('default');

        $this->assertInstanceOf(HandlerConfig::class, $result);

        $this->assertEquals('noop', $result->getType());
        $this->assertEquals(['level' => Logger::DEBUG], $result->getOptions());
    }
}
