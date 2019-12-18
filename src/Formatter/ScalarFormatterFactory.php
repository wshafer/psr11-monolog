<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\ScalarFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class ScalarFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        return new ScalarFormatter();
    }
}
