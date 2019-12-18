<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\FleepHookHandler;
use Monolog\Handler\MissingExtensionException;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class FleepHookHandlerFactory implements FactoryInterface
{
    /**
     * @param array $options
     * @return FleepHookHandler
     * @throws MissingExtensionException
     */
    public function __invoke(array $options)
    {
        $token  = (string)  ($options['token']     ?? '');
        $level  = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble = (bool) ($options['bubble']    ?? true);

        return new FleepHookHandler(
            $token,
            $level,
            $bubble
        );
    }
}
