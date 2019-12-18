<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\InsightOpsHandler;
use Monolog\Handler\MissingExtensionException;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class InsightOpsHandlerFactory implements FactoryInterface
{
    /**
     * @param array $options
     * @return InsightOpsHandler
     * @throws MissingExtensionException
     */
    public function __invoke(array $options)
    {
        $token  = (string)  ($options['token']  ?? '');
        $region = (string)  ($options['region'] ?? '');
        $useSSL = (bool)    ($options['useSSL'] ?? true);
        $level  = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble = (bool) ($options['bubble'] ?? true);

        return new InsightOpsHandler(
            $token,
            $region,
            $useSSL,
            $level,
            $bubble
        );
    }
}
