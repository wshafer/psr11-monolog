<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog;

use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Exception\InvalidConfigException;

abstract class ServiceManagerAbstract implements ServiceManagerInterface
{
    /** @var ContainerInterface */
    protected $container;

    /** @var MapperInterface */
    protected $mapper;

    public function __construct(
        ContainerInterface $container,
        MapperInterface $mapper
    ) {
        $this->container = $container;
        $this->mapper = $mapper;
    }

    public function get(string $type, array $options)
    {
        if ($this->container->has($type)) {
            return $this->container->get($type);
        }

        $className = null;

        if (class_exists($type)
            && in_array(FactoryInterface::class, class_implements($type))
        ) {
            $className = $type;
        }

        if (empty($className)) {
            $className = $this->mapper->map($type);
        }

        if (!$className) {
            throw new InvalidConfigException(
                'Unable to locate a factory by the name of: '.$type
            );
        }

        /** @var FactoryInterface $factory */
        $factory = new $className();

        if (!$factory instanceof FactoryInterface) {
            throw new InvalidConfigException(
                'Class '.$className.' must be an instance of '.FactoryInterface::class
            );
        }

        if ($factory instanceof ContainerAwareInterface) {
            $factory->setContainer($this->container);
        }

        return $factory($options);
    }

    public function has(string $type)
    {
        if ($this->container->has($type)) {
            return true;
        }

        if (class_exists($type)
            && in_array(FactoryInterface::class, class_implements($type))
        ) {
            return true;
        }

        $className = $this->mapper->map($type);

        if ($className) {
            return true;
        }

        return false;
    }
}
