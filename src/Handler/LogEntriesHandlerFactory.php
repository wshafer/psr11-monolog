<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\LogEntriesHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class LogEntriesHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $token  = (string)  ($options['token']     ?? '');
        $useSSL = (boolean) ($options['useSSL']    ?? true);
        $level  = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble = (boolean) ($options['bubble']    ?? true);

        return new LogEntriesHandler(
            $token,
            $useSSL,
            $level,
            $bubble
        );
    }
}
