<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\DynamoDbHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class DynamoDbHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $client  = $this->getService($options['client'] ?? null);
        $table   = (string)  ($options['table']  ?? null);
        $level   = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble  = (bool) ($options['bubble'] ?? true);

        return new DynamoDbHandler(
            $client,
            $table,
            $level,
            $bubble
        );
    }
}
