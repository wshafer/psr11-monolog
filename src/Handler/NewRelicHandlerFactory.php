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
        $bubble          = (boolean) ($options['bubble']          ?? true);
        $appName         = (string)  ($options['appName']         ?? '');
        $explodeArrays   = (boolean) ($options['explodeArrays']   ?? false);
        $transactionName = (string)  ($options['transactionName'] ?? '');

        return new NewRelicHandler(
            $level,
            $bubble,
            $appName,
            $explodeArrays,
            $transactionName
        );
    }
}
