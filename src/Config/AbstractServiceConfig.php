<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Config;

use WShafer\PSR11MonoLog\ConfigInterface;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;

abstract class AbstractServiceConfig implements ConfigInterface
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

        if (empty($config['type'])) {
            throw new MissingConfigException(
                'No config key of "type" found in adaptor config array.'
            );
        }
    }

    public function getType(): string
    {
        return $this->config['type'];
    }

    public function getOptions()
    {
        return $this->config['options'] ?? [];
    }
}
