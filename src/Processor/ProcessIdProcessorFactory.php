<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Processor\ProcessIdProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class ProcessIdProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        return new ProcessIdProcessor();
    }
}
