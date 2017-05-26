<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\LogglyFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class LogglyFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $batchMode     =            $options['batchMode']     ?? LogglyFormatter::BATCH_MODE_NEWLINES;
        $appendNewline = (boolean) ($options['appendNewline'] ?? true);
        return new LogglyFormatter($batchMode, $appendNewline);
    }
}
