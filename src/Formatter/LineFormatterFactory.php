<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use Monolog\Formatter\LineFormatter;
use WShafer\PSR11MonoLog\FactoryInterface;

/**
 * @SuppressWarnings("LongVariable")
 */
class LineFormatterFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $format                     =         $options['format']                     ?? null;
        $dateFormat                 =         $options['dateFormat']                 ?? null;
        $allowInlineLineBreaks      = (bool) ($options['allowInlineLineBreaks']      ?? false);
        $ignoreEmptyContextAndExtra = (bool) ($options['ignoreEmptyContextAndExtra'] ?? false);

        return new LineFormatter($format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }
}
