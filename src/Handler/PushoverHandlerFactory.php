<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\NativeMailerHandler;
use Monolog\Handler\PushoverHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class PushoverHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $token = (string) $options['token'] ?? true;
        $users = $options['users'] ?? [];
        $title = (string) $options['title'] ?? true;
        $level = $options['level'] ?? Logger::DEBUG;
        $bubble = (boolean) $options['bubble'] ?? true;
        $useSSL = (boolean) $options['useSSL'] ?? true;
        $highPriorityLevel = $options['highPriorityLevel'] ?? Logger::CRITICAL;
        $emergencyLevel = $options['emergencyLevel'] ?? Logger::EMERGENCY;
        $retry = $options['retry'] ?? 30;
        $expire = $options['expire'] ?? 25200;

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
