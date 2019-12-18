<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SocketHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class SocketHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $connectionString  = (string)  ($options['connectionString'] ?? '');
        $timeout           = (float)   ($options['timeout']          ?? ini_get('default_socket_timeout'));
        $writeTimeout      = (int)     ($options['writeTimeout']     ?? ini_get('default_socket_timeout'));
        $level             = (int)     ($options['level']            ?? Logger::DEBUG);
        $bubble            = (boolean) ($options['bubble']           ?? true);

        $handler = new SocketHandler(
            $connectionString,
            $level,
            $bubble
        );

        if (!empty($timeout)) {
            $handler->setConnectionTimeout($timeout);
        }

        if (!empty($writeTimeout)) {
            $handler->setTimeout($writeTimeout);
            $handler->setWritingTimeout($writeTimeout);
        }

        return $handler;
    }
}
