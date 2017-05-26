<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\NormalizerFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class NormalizerFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $dateFormat = (string) ($options['dateFormat'] ?? null);
        return new NormalizerFormatter($dateFormat);
    }
}
