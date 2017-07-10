<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\JsonFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

class JsonFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $batchMode     = (int)     ($options['batchMode']     ?? JsonFormatter::BATCH_MODE_JSON);
        $appendNewline = (boolean) ($options['appendNewline'] ?? true);
        return new JsonFormatter($batchMode, $appendNewline);
    }
}
