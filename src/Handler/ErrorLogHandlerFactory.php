<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class ErrorLogHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $messageType = (int) $options['messageType'] ?? ErrorLogHandler::OPERATING_SYSTEM;
        $level = $options['level'] ?? Logger::DEBUG;
        $bubble = (boolean) $options['bubble'] ?? true;
        $expandNewlines = (boolean) $options['expandNewlines'] ?? false;

        return new ErrorLogHandler($messageType, $level, $bubble, $expandNewlines);
    }
}
