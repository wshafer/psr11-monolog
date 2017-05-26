<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\GelfMessageFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class GelfMessageFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $systemName     = (string) ($options['systemName']    ?? null);
        $extraPrefix    = (string) ($options['extraPrefix']   ?? null);
        $contextPrefix  = (string) ($options['contextPrefix'] ?? 'ctxt_');

        return new GelfMessageFormatter($systemName, $extraPrefix, $contextPrefix);
    }
}
