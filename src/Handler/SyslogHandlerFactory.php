<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SyslogHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class SyslogHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $ident = (string) $options['ident'] ?? false;
        $facility = (int) $options['facility'] ?? LOG_USER;
        $level = $options['level'] ?? Logger::DEBUG;
        $bubble = (boolean) $options['bubble'] ?? true;
        $logOpts = $options['logOpts'] ?? LOG_PID;

        return new SyslogHandler($ident, $facility, $level, $bubble, $logOpts);
    }
}
