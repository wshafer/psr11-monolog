<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Stub;

use Monolog\Handler\HandlerInterface;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\ConfigInterface;
use WShafer\PSR11MonoLog\MapperInterface;
use WShafer\PSR11MonoLog\Service\AbstractServiceManager;

class ServiceManagerStub extends AbstractServiceManager
{
    protected $configuration;

    protected $hasValue = true;

    public const INTERFACE = HandlerInterface::class;

    public function __construct(MainConfig $config, MapperInterface $mapper, ContainerInterface $container)
    {
        parent::__construct($config, $mapper, $container);
    }

    protected function getServiceConfig($id): ConfigInterface
    {
        return $this->configuration;
    }

    protected function hasServiceConfig($id): bool
    {
        return $this->hasValue;
    }

    public function setServiceConfig(ConfigInterface $config)
    {
        $this->configuration = $config;
    }

    public function setHasServiceConfig($value)
    {
        $this->hasValue = $value;
    }
}
