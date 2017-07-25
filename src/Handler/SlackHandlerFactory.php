<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SlackHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class SlackHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $token              = (string)  ($options['token']                  ?? '');
        $channel            = (string)  ($options['channel']                ?? '');
        $userName           =            $options['userName']               ?? null;
        $useAttachment      = (boolean) ($options['useAttachment']          ?? true);
        $iconEmoji          =            $options['iconEmoji']              ?? null;
        $level              = (int)     ($options['level']                  ?? Logger::DEBUG);
        $bubble             = (boolean) ($options['bubble']                 ?? true);
        $useShortAttachment = (boolean) ($options['useShortAttachment']     ?? false);
        $includeContext     = (boolean) ($options['includeContextAndExtra'] ?? false);
        $excludeFields      = (array)   ($options['excludeFields']          ?? []);

        return new SlackHandler(
            $token,
            $channel,
            $userName,
            $useAttachment,
            $iconEmoji,
            $level,
            $bubble,
            $useShortAttachment,
            $includeContext,
            $excludeFields
        );
    }
}
