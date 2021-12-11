<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Antidot\Async\Logger\ReactFilesystemHandler;
use Monolog\Logger;
use React\EventLoop\Loop;
use WShafer\PSR11MonoLog\FactoryInterface;

final class ReactFilesystemHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $logPath = $options['stream'];
        $level = (int)($options['level'] ?? Logger::DEBUG);
        $bubble = (bool)($options['bubble'] ?? true);

        return new ReactFilesystemHandler(
            Loop::get(),
            $logPath,
            $level,
            $bubble
        );
    }
}
