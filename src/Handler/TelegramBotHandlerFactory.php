<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\TelegramBotHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class TelegramBotHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $apiKey     = (string)  ($options['apiKey']  ?? '');
        $channel    = (string)  ($options['channel'] ?? '');
        $level      = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble     = (boolean) ($options['bubble']  ?? true);

        return new TelegramBotHandler(
            $apiKey,
            $channel,
            $level,
            $bubble
        );
    }
}
