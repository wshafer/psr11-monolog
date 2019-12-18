<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Processor\PsrLogMessageProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class PsrLogMessageProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        return new PsrLogMessageProcessor();
    }
}
