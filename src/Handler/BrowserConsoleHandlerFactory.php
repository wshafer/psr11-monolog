<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class BrowserConsoleHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $level  = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble = (boolean) ($options['bubble'] ?? true);

        return new BrowserConsoleHandler(
            $level,
            $bubble
        );
    }
}
