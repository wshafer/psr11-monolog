<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\NoopHandler;
use WShafer\PSR11MonoLog\FactoryInterface;

class NoopHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        return new NoopHandler();
    }
}
