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

    /** @var ProcessorConfig[] */
    protected $processors = [];

    public function __construct(array $config)
    {
        $this->validateConfig($config);
        $this->buildFormatters($config);
        $this->buildHandlers($config);
        $this->buildChannels($config);
        $this->buildProcessors($config);
    }

    /**
     * @return HandlerConfig[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    public function hasHandlerConfig($handler) : bool
    {
        return key_exists($handler, $this->handlers);
    }

    /**
     * @param $handler
     * @return null|HandlerConfig
     */
    public function getHandlerConfig($handler)
    {
        return $this->handlers[$handler] ?? null;
    }

    /**
     * @return FormatterConfig[]
     */
    public function getFormatters() : array
    {
        return $this->formatters;
    }

    public function hasFormatterConfig($formatter) : bool
    {
        return key_exists($formatter, $this->formatters);
    }

    /**
     * @param $formatter
     * @return null|FormatterConfig
     */
    public function getFormatterConfig($formatter)
    {
        return $this->formatters[$formatter] ?? null;
    }

    /**
     * @return FormatterConfig[]
     */
    public function getProcessors() : array
    {
        return $this->processors;
    }

    public function hasProcessorConfig($processor) : bool
    {
        return key_exists($processor, $this->processors);
    }

    /**
     * @param $processor
     * @return null|ProcessorConfig
     */
    public function getProcessorConfig($processor)
    {
        return $this->processors[$processor] ?? null;
    }

    /**
     * @return ChannelConfig[]
     */
    public function getChannels() : array
    {
        return $this->channels;
    }

    /**
     * @param $channel
     * @return bool
     */
    public function hasChannelConfig($channel) : bool
    {
        return key_exists($channel, $this->channels);
    }

    public function getChannelConfig($channel)
    {
        return $this->channels[$channel] ?? null;
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

    protected function buildProcessors($config)
    {
        if (empty($config['monolog']['processors'])) {
            return;
        }

        foreach ($config['monolog']['processors'] as $name => $processorConfig) {
            $this->processors[$name] = new ProcessorConfig($processorConfig);
        }
    }
}
