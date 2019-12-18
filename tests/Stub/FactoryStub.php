<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Stub;

use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;

class FactoryStub implements FactoryInterface, ContainerAwareInterface
{
    protected $container;

    public function __invoke(array $options)
    {
        return new HandlerStub();
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
