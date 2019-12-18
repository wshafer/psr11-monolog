<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SendGridHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class SendGridHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $apiUser    = (string)  ($options['apiUser'] ?? '');
        $apiKey     = (string)  ($options['apiKey']  ?? '');
        $from       = (string)  ($options['from']    ?? '');
        $to         =           ($options['to']      ?? '');
        $subject    = (string)  ($options['subject'] ?? '');
        $level      = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble     = (boolean) ($options['bubble']  ?? true);

        return new SendGridHandler(
            $apiUser,
            $apiKey,
            $from,
            $to,
            $subject,
            $level,
            $bubble
        );
    }
}
