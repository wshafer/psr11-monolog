<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Config;

use WShafer\PSR11MonoLog\Exception\MissingConfigException;

class ChannelConfig
{
    protected $config = [];

    public function __construct(array $config)
    {
        $this->validateConfig($config);
        $this->config = $config;
    }

    protected function validateConfig($config)
    {
        if (empty($config)) {
            throw new MissingConfigException(
                'No config found'
            );
        }

        if (empty($config['handlers'])) {
            throw new MissingConfigException(
                'No config key of "handlers" found in channel config array.'
            );
        }
    }

    public function getHandlers()
    {
        return $this->config['handlers'];
    }

    public function getProcessors()
    {
        return $this->config['processors'] ?? [];
    }
}
