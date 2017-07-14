<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Processor\MemoryPeakUsageProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class MemoryPeakUsageProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        return new MemoryPeakUsageProcessor();
    }
}
