<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\LogmaticFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class LogmaticFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $batchMode     = (int)     ($options['batchMode']     ?? JsonFormatter::BATCH_MODE_JSON);
        $appendNewline = (bool) ($options['appendNewline'] ?? true);
        $hostmane      = (string)  ($options['hostname'] ?? '');
        $appName       = (string)  ($options['appName'] ?? '');

        $formatter = new LogmaticFormatter($batchMode, $appendNewline);

        if (!empty($hostmane)) {
            $formatter->setHostname($hostmane);
        }

        if (!empty($appName)) {
            $formatter->setAppname($appName);
        }

        return $formatter;
    }
}
