<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\WildfireFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class WildfireFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $dateFormat = (string) ($options['dateFormat'] ?? null);
        return new WildfireFormatter($dateFormat);
    }
}
