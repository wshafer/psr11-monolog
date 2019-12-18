<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\ChromePHPFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class ChromePHPFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        return new ChromePHPFormatter();
    }
}
