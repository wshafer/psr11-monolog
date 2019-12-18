<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\MongoDBHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class MongoDBHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $client     = $this->getService($options['client'] ?? null);
        $database   = (string)  ($options['database']   ?? '');
        $collection = (string)  ($options['collection'] ?? '');
        $level      = (int)     ($options['level']      ?? Logger::DEBUG);
        $bubble     = (bool) ($options['bubble']     ?? true);

        return new MongoDBHandler(
            $client,
            $database,
            $collection,
            $level,
            $bubble
        );
    }
}
