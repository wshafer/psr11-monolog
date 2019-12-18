<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\HtmlFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class HtmlFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $dateFormat = $options['dateFormat'] ?? null;
        return new HtmlFormatter($dateFormat);
    }
}
