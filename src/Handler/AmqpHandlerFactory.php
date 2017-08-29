<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\AmqpHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class AmqpHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $exchange     = $this->getService($options['exchange'] ?? null);
        $exchangeName = (string)  ($options['exchangeName'] ?? 'log');
        $level        = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble       = (boolean) ($options['bubble']    ?? true);

        return new AmqpHandler(
            $exchange,
            $exchangeName,
            $level,
            $bubble
        );
    }
}
