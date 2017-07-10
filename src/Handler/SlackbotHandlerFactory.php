<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SlackbotHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class SlackbotHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $slackTeam = (string)  ($options['slackTeam'] ?? '');
        $token     = (string)  ($options['token']     ?? '');
        $channel   = (string)  ($options['channel']   ?? '');
        $level     = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble    = (boolean) ($options['bubble']    ?? true);

        return new SlackbotHandler(
            $slackTeam,
            $token,
            $channel,
            $level,
            $bubble
        );
    }
}
