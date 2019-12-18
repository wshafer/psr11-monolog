<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\LogstashFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class LogstashFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $applicationName =           $options['applicationName'] ?? '';
        $systemName      =           $options['systemName']      ?? '';
        $extraPrefix     =           $options['extraPrefix']     ?? '';
        $contextPrefix   = (string) ($options['contextPrefix']   ?? 'ctxt_');

        return new LogstashFormatter($applicationName, $systemName, $extraPrefix, $contextPrefix);
    }
}
