<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\GelfMessageFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class GelfMessageFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $systemName     = $options['systemName']    ?? null;
        $extraPrefix    = $options['extraPrefix']   ?? null;
        $contextPrefix  = $options['contextPrefix'] ?? 'ctxt_';
        $maxLength      = $options['maxLength']     ?? null;

        return new GelfMessageFormatter($systemName, $extraPrefix, $contextPrefix, $maxLength);
    }
}
