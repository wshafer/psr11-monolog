<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Processor\TagProcessor;
use WShafer\PSR11MonoLog\FactoryInterface;

class TagProcessorFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $tags = (array) ($options['tags'] ?? []);
        return new TagProcessor($tags);
    }
}
