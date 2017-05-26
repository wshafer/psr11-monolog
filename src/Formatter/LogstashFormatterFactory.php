<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\LogstashFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class LogstashFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $applicationName = (string) ($options['applicationName'] ?? null);
        $systemName      = (string) ($options['systemName']      ?? null);
        $extraPrefix     = (string) ($options['extraPrefix']     ?? null);
        $contextPrefix   = (string) ($options['contextPrefix']   ?? 'ctxt_');

        return new LogstashFormatter($applicationName, $systemName, $extraPrefix, $contextPrefix);
    }
}
