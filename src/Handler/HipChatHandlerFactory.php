<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\HipChatHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class HipChatHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $token = (string) $options['token'] ?? '';
        $room = (string) $options['room'] ?? '';
        $name = (string) $options['name'] ?? 'Monolog';
        $notify = (boolean) $options['notify'] ?? false;
        $level = (int) $options['level'] ?? Logger::DEBUG;
        $bubble = (boolean) $options['bubble'] ?? true;
        $useSSL = (boolean) $options['useSSL'] ?? true;
        $format = (string) $options['format'] ?? 'text';
        $host = (string) $options['host'] ?? 'api.hipchat.com';

        return new HipChatHandler(
            $token,
            $room,
            $name,
            $notify,
            $level,
            $bubble,
            $useSSL,
            $format,
            $host
        );
    }
}
