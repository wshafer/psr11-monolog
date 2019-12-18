<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\ProcessHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class ProcessHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $command    = (string)  ($options['command'] ?? null);
        $cwd        = (string)  ($options['cwd']     ?? null);
        $level      = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble     = (bool) ($options['bubble']  ?? true);

        return new ProcessHandler(
            $command,
            $level,
            $bubble,
            $cwd
        );
    }
}
