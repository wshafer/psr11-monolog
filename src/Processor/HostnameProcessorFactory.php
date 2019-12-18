<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Processor\HostnameProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class HostnameProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        return new HostnameProcessor();
    }
}
