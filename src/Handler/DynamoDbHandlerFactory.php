<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\DynamoDbHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ClientTrait;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;

class DynamoDbHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ClientTrait;

    public function __invoke(array $options)
    {
        $client  = $this->getClient($options);
        $table   = (string)  ($options['table']  ?? null);
        $level   = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble  = (boolean) ($options['bubble'] ?? true);

        return new DynamoDbHandler(
            $client,
            $table,
            $level,
            $bubble
        );
    }
}
