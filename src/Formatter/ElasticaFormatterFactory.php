<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\ElasticaFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class ElasticaFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $index = (string) ($options['index'] ?? null);
        $type  = (string) ($options['type']  ?? null);
        return new ElasticaFormatter($index, $type);
    }
}
