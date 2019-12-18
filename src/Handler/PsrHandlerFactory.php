<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\PsrHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class PsrHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $logger     = $this->getService($options['logger'] ?? null);
        $level      = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble     = (bool) ($options['bubble'] ?? true);

        return new PsrHandler(
            $logger,
            $level,
            $bubble
        );
    }
}
