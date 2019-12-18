<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SqsHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class SqsHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $sqsClient = $this->getService($options['sqsClient'] ?? null);

        $queueUrl  = (string)  ($options['queueUrl']  ?? Logger::DEBUG);
        $level     = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble    = (bool) ($options['bubble'] ?? true);

        return new SqsHandler($sqsClient, $queueUrl, $level, $bubble);
    }
}
