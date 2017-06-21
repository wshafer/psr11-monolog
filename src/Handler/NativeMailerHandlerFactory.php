<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\NativeMailerHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class NativeMailerHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $to = (array) $options['to'] ?? true;
        $subject = (string) $options['subject'] ?? true;
        $from = (string) $options['from'] ?? true;
        $level = $options['level'] ?? Logger::DEBUG;
        $bubble = (boolean) $options['bubble'] ?? true;
        $maxColumnWidth = (int) $options['maxColumnWidth'] ?? 70;

        return new NativeMailerHandler($to, $subject, $from, $level, $bubble, $maxColumnWidth);
    }
}
