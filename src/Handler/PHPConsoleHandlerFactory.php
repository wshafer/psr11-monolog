<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\PHPConsoleHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;
use WShafer\PSR11MonoLog\ServiceTrait;

class PHPConsoleHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ServiceTrait;

    public function __invoke(array $options)
    {
        $consoleOptions = (array)   ($options['options'] ?? []);
        $connector      = $this->getService($options['connector'] ?? null);
        $level          = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble         = (bool) ($options['bubble']  ?? true);

        return new PHPConsoleHandler(
            $consoleOptions,
            $connector,
            $level,
            $bubble
        );
    }
}
