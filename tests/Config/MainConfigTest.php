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

    protected function getConfigArray()
    {
        return [
            'monolog' => [
                'formatters' => [
                    'formatterOne' => [
                        'type' => 'LineFormatter',
                        'options' => [
                            'format' => "%datetime% > %level_name% > %message% %context% %extra%\n",
                            'dateFormat' => 'Y n j, g:i a',
                        ],
                    ],

                    'formatterTwo' => [
                        'type' => 'LineFormatter',
                        'options' => [
                            'format' => "[%datetime%][%level_name%] %message% %context% %extra%\n",
                            'dateFormat' => 'Y n j, g:i a',
                        ],
                    ],
                ],

                'handlers' => [
                    'handlerOne' => [
                        'type' => 'StreamHandler',
                        'formatter' => 'formatterOne',
                        'options' => [
                            'stream' => '/tmp/logOne.txt',
                            'level' => Logger::ERROR,
                            'bubble' =>  true,
                            'filePermission' => 755,
                            'useLocking' => true
                        ],
                    ],

                    'handlerTwo' => [
                        'type' => 'StreamHandler',
                        'formatter' => 'formatterOne',
                        'options' => [
                            'stream' => '/tmp/logOne.txt',
                            'level' => Logger::ERROR,
                            'bubble' =>  true,
                            'filePermission' => 755,
                            'useLocking' => true
                        ],
                    ],
                ],

                'processors' => [
                    'processorOne' => [
                        'type' => 'introspection',
                        'options' => [
                            'dateFormat' => 'Y n j, g:i a',
                        ],
                    ],
                ],

                'channels' => [
                    'myChannel' => [
                        'handlers' => [
                            'handlerOne',
                            'handlerTwo'
                        ],

                        'processors' => [
                            'serviceOne',
                            'serviceTwo'
                        ],
                    ],
                ],
            ],
        ];
    }

    public function setup()
    {
        $this->config = new MainConfig($this->getConfigArray());

        $this->assertInstanceOf(MainConfig::class, $this->config);
    }

    public function testConstructor()
    {
    }

    public function testConstructorMissingConfig()
    {
        $this->expectException(MissingConfigException::class);
        new MainConfig([]);
    }

    public function testConstructorMissingHandlerConfig()
    {
        $this->expectException(MissingConfigException::class);

        $config = $this->getConfigArray();
        unset($config['monolog']['handlers']);

        new MainConfig($config);
    }

    public function testConstructorMissingChannelConfig()
    {
        $this->expectException(MissingConfigException::class);

        $config = $this->getConfigArray();
        unset($config['monolog']['channels']);

        new MainConfig($config);
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
}
