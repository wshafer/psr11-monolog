<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\TestHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class TestHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $level      = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble     = (bool) ($options['bubble'] ?? true);

        return new TestHandler(
            $level,
            $bubble
        );
    }
}
