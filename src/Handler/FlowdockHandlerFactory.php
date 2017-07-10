<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\FlowdockHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class FlowdockHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $apiToken = (string) $options['apiToken'] ?? '';
        $level = (int) $options['level'] ?? Logger::DEBUG;
        $bubble = (boolean) $options['bubble'] ?? true;

        return new FlowdockHandler(
            $apiToken,
            $level,
            $bubble
        );
    }
}
