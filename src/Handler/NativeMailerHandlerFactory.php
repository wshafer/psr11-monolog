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
        $toEmail        = (array)   ($options['to']             ?? []);
        $subject        = (string)  ($options['subject']        ?? true);
        $fromEmail      = (string)  ($options['from']           ?? '');
        $level          = (int)     ($options['level']          ?? Logger::DEBUG);
        $bubble         = (boolean) ($options['bubble']         ?? true);
        $maxColumnWidth = (int)     ($options['maxColumnWidth'] ?? 70);

        return new NativeMailerHandler($toEmail, $subject, $fromEmail, $level, $bubble, $maxColumnWidth);
    }
}
