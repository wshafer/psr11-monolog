<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\LogEntriesHandler;
use Monolog\Handler\MissingExtensionException;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class LogEntriesHandlerFactory implements FactoryInterface
{
    /**
     * @param array $options
     * @return LogEntriesHandler
     * @throws MissingExtensionException
     */
    public function __invoke(array $options)
    {
        $token  = (string)  ($options['token']     ?? '');
        $useSSL = (bool) ($options['useSSL']    ?? true);
        $level  = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble = (bool) ($options['bubble']    ?? true);

        return new LogEntriesHandler(
            $token,
            $useSSL,
            $level,
            $bubble
        );
    }
}
