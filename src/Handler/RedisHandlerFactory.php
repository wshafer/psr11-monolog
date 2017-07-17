<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\RedisHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ClientTrait;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;

class RedisHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ClientTrait;

    public function __invoke(array $options)
    {
        $client  = $this->getClient($options);
        $key     = (string)  ($options['key']     ?? '');
        $level   = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble  = (boolean) ($options['bubble']  ?? true);
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
