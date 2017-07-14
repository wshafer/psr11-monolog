<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Processor\UidProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class UidProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $length = (int) ($options['length'] ?? 7);
        return new UidProcessor($length);
    }
}
