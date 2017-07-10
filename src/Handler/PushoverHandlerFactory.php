<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\PushoverHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class PushoverHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $token             = (string)  ($options['token']             ?? '');
        $users             = (array)   ($options['users']             ?? []);
        $title             = (string)  ($options['title']             ?? '');
        $level             = (int)     ($options['level']             ?? Logger::DEBUG);
        $bubble            = (boolean) ($options['bubble']            ?? true);
        $useSSL            = (boolean) ($options['useSSL']            ?? true);
        $highPriorityLevel = (int)     ($options['highPriorityLevel'] ?? Logger::CRITICAL);
        $emergencyLevel    = (int)     ($options['emergencyLevel']    ?? Logger::EMERGENCY);
        $retry             = (int)     ($options['retry']             ?? 30);
        $expire            = (int)     ($options['expire']            ?? 25200);

        return new PushoverHandler(
            $token,
            $users,
            $title,
            $level,
            $bubble,
            $useSSL,
            $highPriorityLevel,
            $emergencyLevel,
            $retry,
            $expire
        );
    }
}
