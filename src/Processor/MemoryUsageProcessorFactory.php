<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Processor\MemoryUsageProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class MemoryUsageProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        return new MemoryUsageProcessor();
    }
}
