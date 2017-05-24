<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Config;

use WShafer\PSR11MonoLog\Exception\MissingConfigException;

class MainConfig
{
    /** @var HandlerConfig[] */
    protected $handlers = [];

    /** @var FormatterConfig[] */
    protected $formatters = [];

    /** @var ChannelConfig[] */
    protected $channels = [];

    public function __construct(array $config)
    {
        $this->validateConfig($config);
        $this->config = $config;
        $this->buildFormatters($config);
        $this->buildHandlers($config);
        $this->buildChannels($config);
    }

    /**
     * @return HandlerConfig[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @return FormatterConfig[]
     */
    public function getFormatters()
    {
        return $this->formatters;
    }

    /**
     * @return ChannelConfig[]
     */
    public function getChannels()
    {
        return $this->channels;
    }

    protected function validateConfig($config)
    {
        if (empty($config)
            || empty($config['monolog'])
        ) {
            throw new MissingConfigException(
                'No config key of "monolog" found in config array.'
            );
        }

        if (empty($config['monolog']['handlers'])) {
            throw new MissingConfigException(
                'No config key of "handlers" found in monolog config array.'
            );
        }

        if (empty($config['monolog']['channels'])) {
            throw new MissingConfigException(
                'No config key of "handlers" found in monolog config array.'
            );
        }
    }

    protected function buildHandlers($config)
    {
        foreach ($config['monolog']['handlers'] as $name => $handlerConfig) {
            $this->handlers[$name] = new HandlerConfig($handlerConfig);
        }
    }

    protected function buildChannels($config)
    {
        foreach ($config['monolog']['channels'] as $name => $channelConfig) {
            $this->channels[$name] = new ChannelConfig($channelConfig);
        }
    }

    protected function buildFormatters($config)
    {
        if (empty($config['monolog']['formatters'])) {
            return;
        }

        foreach ($config['monolog']['formatters'] as $name => $formatterConfig) {
            $this->formatters[$name] = new FormatterConfig($formatterConfig);
        }
    }
}
