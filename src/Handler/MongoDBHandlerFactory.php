<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\MongoDBHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ClientTrait;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;

class MongoDBHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ClientTrait;

    public function __invoke(array $options)
    {
        $client     = $this->getClient($options);
        $database   = (string)  ($options['database']   ?? '');
        $collection = (string)  ($options['collection'] ?? '');
        $level      = (int)     ($options['level']      ?? Logger::DEBUG);
        $bubble     = (boolean) ($options['bubble']     ?? true);

        return new MongoDBHandler(
            $client,
            $database,
            $collection,
            $level,
            $bubble
        );
    }
}
