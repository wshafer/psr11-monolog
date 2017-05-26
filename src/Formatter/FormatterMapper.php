<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Formatter;

use WShafer\PSR11MonoLog\MapperAbstract;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FormatterMapper extends MapperAbstract
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getFactoryClassName(string $type)
    {
        if (class_exists($type)
            && $type != 'normalizer'  //  Clash with INTL ext
        ) {
            return $type;
        }

        switch ($type) {
            case 'line':
                return LineFormatterFactory::class;
            case 'html':
                return HtmlFormatterFactory::class;
            case 'normalizer':
                return NormalizerFormatterFactory::class;
            case 'scalar':
                return ScalarFormatterFactory::class;
            case 'json':
                return JsonFormatterFactory::class;
            case 'wildfire':
                return WildfireFormatterFactory::class;
            case 'chromePHP':
                return ChromePHPFormatterFactory::class;
            case 'gelf':
                return GelfMessageFormatterFactory::class;
            case 'logstash':
                return LogstashFormatterFactory::class;
            case 'elastica':
                return ElasticaFormatterFactory::class;
            case 'loggly':
                return LogglyFormatterFactory::class;
            case 'flowdock':
                return FlowdockFormatterFactory::class;
            case 'mongodb':
                return MongoDBFormatterFactory::class;
        }

        return null;
    }
}
