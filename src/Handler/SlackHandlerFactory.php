<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\SlackHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class SlackHandlerFactory implements FactoryInterface
{
    /**
     * @param array $options
     * @return SlackHandler
     * @throws MissingExtensionException
     */
    public function __invoke(array $options)
    {
        $token              = (string)  ($options['token']                  ?? '');
        $channel            = (string)  ($options['channel']                ?? '');
        $userName           =            $options['userName']               ?? null;
        $useAttachment      = (bool) ($options['useAttachment']          ?? true);
        $iconEmoji          =            $options['iconEmoji']              ?? null;
        $level              = (int)     ($options['level']                  ?? Logger::DEBUG);
        $bubble             = (bool) ($options['bubble']                 ?? true);
        $useShortAttachment = (bool) ($options['useShortAttachment']     ?? false);
        $includeContext     = (bool) ($options['includeContextAndExtra'] ?? false);
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
