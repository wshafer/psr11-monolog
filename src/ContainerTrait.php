<?php

namespace WShafer\PSR11MonoLog;

use Psr\Container\ContainerInterface;

trait ContainerTrait
{
    /** @var ContainerInterface */
    protected $container;

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
