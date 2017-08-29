<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\NullHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class NullHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $level = (int) ($options['level'] ?? Logger::DEBUG);

        return new NullHandler($level);
    }
}
