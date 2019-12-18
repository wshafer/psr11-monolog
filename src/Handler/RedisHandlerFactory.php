<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\RedisHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class RedisHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $client  = $this->getService($options['client'] ?? []);
        $key     = (string)  ($options['key']     ?? '');
        $level   = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble  = (bool) ($options['bubble']  ?? true);
        $capSize = (int)     ($options['capSize'] ?? 0);

        return new RedisHandler(
            $client,
            $key,
            $level,
            $bubble,
            $capSize
        );
    }
}
