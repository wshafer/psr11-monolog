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
        $channel            = (string)  ($options['channel']                ?? '');
        $userName           = (string)  ($options['userName']               ?? '');
        $useAttachment      = (boolean) ($options['useAttachment']          ?? true);
        $iconEmoji          = (string)  ($options['iconEmoji']              ?? '');
        $useShortAttachment = (boolean) ($options['useShortAttachment']     ?? false);
        $includeContext     = (boolean) ($options['includeContextAndExtra'] ?? false);
        $level              = (int)     ($options['level']                  ?? Logger::DEBUG);
        $bubble             = (boolean) ($options['bubble']                 ?? true);
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
