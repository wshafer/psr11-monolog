<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Logger;
use Monolog\Processor\GitProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class GitProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $level = (int) ($options['level'] ?? Logger::DEBUG);
        return new GitProcessor($level);
    }
}
