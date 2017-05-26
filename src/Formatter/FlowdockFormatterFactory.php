<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\FlowdockFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class FlowdockFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $source      = (string) ($options['source']      ?? null);
        $sourceEmail = (string) ($options['sourceEmail'] ?? null);
        return new FlowdockFormatter($source, $sourceEmail);
    }
}
