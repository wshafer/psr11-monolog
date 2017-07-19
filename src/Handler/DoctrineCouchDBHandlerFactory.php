<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\DoctrineCouchDBHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ClientTrait;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;

class DoctrineCouchDBHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ClientTrait;

    public function __invoke(array $options)
    {
        $client  = $this->getClient($options);
        $level   = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble  = (boolean) ($options['bubble']  ?? true);

        return new DoctrineCouchDBHandler(
            $client,
            $level,
            $bubble
        );
    }
}
