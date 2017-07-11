<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\FleepHookHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class FleepHookHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $token     = (string)  ($options['token']     ?? '');
        $level     = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble    = (boolean) ($options['bubble']    ?? true);

        return new FleepHookHandler(
            $token,
            $level,
            $bubble
        );
    }
}
