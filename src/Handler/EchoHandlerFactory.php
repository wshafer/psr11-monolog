<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Antidot\Async\Logger\EchoHandler;
use Antidot\Async\Logger\ReactFilesystemHandler;
use Monolog\Logger;
use React\EventLoop\Loop;
use WShafer\PSR11MonoLog\FactoryInterface;

final class EchoHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $level = (int)($options['level'] ?? Logger::DEBUG);
        $bubble = (bool)($options['bubble'] ?? true);

        return new EchoHandler(
            $level,
            $bubble
        );
    }
}
