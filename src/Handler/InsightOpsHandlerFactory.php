<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\InsightOpsHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class InsightOpsHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $token  = (string)  ($options['token']  ?? '');
        $region = (string)  ($options['region'] ?? '');
        $useSSL = (bool)    ($options['useSSL'] ?? true);
        $level  = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble = (boolean) ($options['bubble'] ?? true);

        return new InsightOpsHandler(
            $token,
            $region,
            $useSSL,
            $level,
            $bubble
        );
    }
}
