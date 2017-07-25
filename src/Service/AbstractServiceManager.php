<?php

namespace WShafer\PSR11MonoLog\Service;

use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\ConfigInterface;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\Exception\InvalidConfigException;
use WShafer\PSR11MonoLog\Exception\UnknownServiceException;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\MapperInterface;

abstract class AbstractServiceManager implements ContainerInterface
{
    /** @var MainConfig */
    protected $config;

    /** @var MapperInterface */
    protected $mapper;

    /** @var ContainerInterface */
    protected $container;

    /** @var array */
    protected $services = [];

    public function __construct(
        MainConfig $config,
        MapperInterface $mapper,
        ContainerInterface $container
    ) {
        $this->config    = $config;
        $this->mapper    = $mapper;
        $this->container = $container;
    }

    abstract protected function getServiceConfig($id) : ConfigInterface;
    abstract protected function hasServiceConfig($id) : bool;

    public function get($id)
    {
        if (key_exists($id, $this->services)) {
            return $this->services[$id];
        }

        // Make sure we have one of these
        if (!$this->has($id)) {
            throw new UnknownServiceException(
                'Unable to locate service '.$id.'.  Please check your configuration.'
            );
        }

        // Check the main container for this service id.
        if ($this->container->has($id)) {
            $this->services[$id] = $this->container->get($id);
            return $this->services[$id];
        }

        $this->services[$id] = $this->getInstanceFromFactory($id);
        return $this->services[$id];
    }

    public function has($id)
    {
        if (key_exists($id, $this->services)) {
            return true;
        }

        if ($this->container->has($id)) {
            return true;
        }

        return $this->hasServiceConfig($id);
    }

    protected function getInstanceFromFactory($id)
    {
        $class   = null;

        $config  = $this->getServiceConfig($id);
        $type    = $config->getType();
        $options = $config->getOptions();

        $class = $type;

        // Check for class and class implements of Monolog Formatter Interface
        if (!class_exists($class)
            || !in_array(FactoryInterface::class, class_implements($class))
        ) {
            $class = $this->mapper->map($type);
        }

        if (!class_exists($class)
            || !in_array(FactoryInterface::class, class_implements($class))
        ) {
            throw new InvalidConfigException(
                $id.'.  Is not a valid factory.  Please check your configuration.'
            );
        }

        /** @var FactoryInterface $factory */
        $factory = new $class;

        if ($factory instanceof ContainerAwareInterface) {
            $factory->setContainer($this->container);
        }

        return $factory($options);
    }
}
