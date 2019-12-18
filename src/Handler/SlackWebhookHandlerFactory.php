<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SlackWebhookHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class SlackWebhookHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $webhookUrl         = (string)  ($options['webhookUrl']             ?? '');
        $channel            =            $options['channel']                ?? null;
        $userName           =            $options['userName']               ?? null;
        $useAttachment      = (bool) ($options['useAttachment']          ?? true);
        $iconEmoji          =            $options['iconEmoji']              ?? null;
        $useShortAttachment = (bool) ($options['useShortAttachment']     ?? false);
        $includeContext     = (bool) ($options['includeContextAndExtra'] ?? false);
        $level              = (int)     ($options['level']                  ?? Logger::DEBUG);
        $bubble             = (bool) ($options['bubble']                 ?? true);
        $excludeFields      = (array)   ($options['excludeFields']          ?? []);

        return new SlackWebhookHandler(
            $webhookUrl,
            $channel,
            $userName,
            $useAttachment,
            $iconEmoji,
            $useShortAttachment,
            $includeContext,
            $level,
            $bubble,
            $excludeFields
        );
    }
}
