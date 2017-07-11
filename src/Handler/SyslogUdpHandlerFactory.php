<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SyslogUdpHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class SyslogUdpHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $host     = (string)  ($options['host']     ?? '');
        $port     = (int)     ($options['host']     ?? 514);
        $facility = (int)     ($options['facility'] ?? LOG_USER);
        $level    = (int)     ($options['level']    ?? Logger::DEBUG);
        $bubble   = (boolean) ($options['bubble']   ?? true);
        $ident    = (string)  ($options['ident']    ?? 'php');

        return new SyslogUdpHandler(
            $host,
            $port,
            $facility,
            $level,
            $bubble,
            $ident
        );
    }
}
