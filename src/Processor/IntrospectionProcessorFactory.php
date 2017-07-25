<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class IntrospectionProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $level          = (int)   ($options['level']               ?? Logger::DEBUG);
        $skipPartials   = (array) ($options['skipClassesPartials'] ?? []);
        $skipFrameCount = (int)   ($options['skipStackFramesCount'] ?? 0);

        return new IntrospectionProcessor(
            $level,
            $skipPartials,
            $skipFrameCount
        );
    }
}
