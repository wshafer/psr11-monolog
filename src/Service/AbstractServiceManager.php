<?php

namespace WShafer\PSR11MonoLog\Service;

use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\ConfigInterface;
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
    protected $services;
    
    const INTERFACE = '';

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

    public function get($id)
    {
        $interface = self::INTERFACE;
        
        if (key_exists($id, $this->services)
            && $this->services[$id] instanceof $interface
        ) {
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

        // Check for class and class implements of Monolog Interface
        if (class_exists($id)
            && in_array($interface, class_implements($id))
        ) {
            $this->services[$id] = new $id;
            return $this->services[$id];
        }

        $this->services[$id] = $this->getInstanceFromFactory($id);
        return $this->services[$id];
    }

    public function has($id)
    {
        $interface = self::INTERFACE;

        if (key_exists($id, $this->services)
            && $this->services[$id] instanceof $interface
        ) {
            return true;
        }

        if ($this->container->has($id)) {
            return true;
        }

        if (class_exists($id)
            && in_array($interface, class_implements($id))
        ) {
            return true;
        }

        return $this->config->hasHandlerConfig($id);
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
            throw new UnknownServiceException(
                'Unable to locate service '.$id.'.  Please check your configuration.'
            );
        }

        /** @var FactoryInterface $factory */
        $factory = new $class;
        return $factory($options);
    }
}
