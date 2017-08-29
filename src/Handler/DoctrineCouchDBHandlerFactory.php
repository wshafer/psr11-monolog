<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\DoctrineCouchDBHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class DoctrineCouchDBHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $client  = $this->getService($options['client'] ?? null);
        $level   = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble  = (boolean) ($options['bubble']  ?? true);

        return new DoctrineCouchDBHandler(
            $client,
            $level,
            $bubble
        );
    }
}
