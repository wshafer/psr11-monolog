<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\NewRelicHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class NewRelicHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $level           = (int)     ($options['level']           ?? Logger::DEBUG);
        $bubble          = (bool) ($options['bubble']          ?? true);
        $appName         =            $options['appName']         ?? null;
        $explodeArrays   = (bool) ($options['explodeArrays']   ?? false);
        $transactionName =            $options['transactionName'] ?? null;

        return new NewRelicHandler(
            $level,
            $bubble,
            $appName,
            $explodeArrays,
            $transactionName
        );
    }
}
