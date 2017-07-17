<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\CouchDBHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class CouchDBHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $host     = (string)  ($options['host']     ?? 'localhost');
        $port     = (int)     ($options['port']     ?? 5984);
        $dbname   = (string)  ($options['port']     ?? 'logger');
        $userName = (string)  ($options['username'] ?? '');
        $password = (string)  ($options['password'] ?? '');
        $level    = (int)     ($options['level']    ?? Logger::DEBUG);
        $bubble   = (boolean) ($options['bubble']   ?? true);

        return new CouchDBHandler(
            [
                'host'     => $host,
                'port'     => $port,
                'dbname'   => $dbname,
                'username' => $userName,
                'password' => $password
            ],
            $level,
            $bubble
        );
    }
}
