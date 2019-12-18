<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\ElasticaHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class ElasticaHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $client      = $this->getService($options['client'] ?? null);
        $index       = (string)  ($options['index']       ?? 'monolog');
        $type        = (string)  ($options['type']        ?? 'record');
        $ignoreError = (bool) ($options['ignoreError'] ?? false);
        $level       = (int)     ($options['level']       ?? Logger::DEBUG);
        $bubble      = (bool) ($options['bubble']      ?? true);

        return new ElasticaHandler(
            $client,
            [
                'index'        => $index,
                'type'         => $type,
                'ignore_error' => $ignoreError
            ],
            $level,
            $bubble
        );
    }
}
