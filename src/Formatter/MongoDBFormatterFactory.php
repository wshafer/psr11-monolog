<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\MongoDBFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

/**
 * @SuppressWarnings("LongVariable")
 */
class MongoDBFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $maxNestingLevel        = (int)     ($options['maxNestingLevel']        ?? 3);
        $exceptionTraceAsString = (boolean) ($options['exceptionTraceAsString'] ?? true);
        return new MongoDBFormatter($maxNestingLevel, $exceptionTraceAsString);
    }
}
