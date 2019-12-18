<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\GelfHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class GelfHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $publisher = $this->getService($options['publisher'] ?? null);
        $level     = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble    = (bool) ($options['bubble']    ?? true);

        return new GelfHandler(
            $publisher,
            $level,
            $bubble
        );
    }
}
