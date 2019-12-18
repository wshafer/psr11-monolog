<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\LogmaticHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class LogmaticHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $token    = (string)  ($options['token']  ?? '');
        $hostname = (string)  ($options['hostname'] ?? '');
        $appname  = (string)  ($options['appname'] ?? '');
        $useSSL   = (bool)    ($options['useSSL'] ?? true);
        $level    = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble   = (boolean) ($options['bubble'] ?? true);

        return new LogmaticHandler(
            $token,
            $hostname,
            $appname,
            $useSSL,
            $level,
            $bubble
        );
    }
}
