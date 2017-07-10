<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use WShafer\PSR11MonoLog\MapperInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class HandlerMapper implements MapperInterface
{
    /**
     * @param string $type
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function map(string $type)
    {
        $type = strtolower($type);

        switch ($type) {
            case 'stream':
                return StreamHandlerFactory::class;
            case 'rotating':
                return RotatingFileHandlerFactory::class;
            case 'syslog':
                return SyslogHandlerFactory::class;
            case 'errorlog':
                return ErrorLogHandlerFactory::class;
            case 'nativemailer':
                return NativeMailerHandlerFactory::class;
            case 'swiftmailer':
                return SwiftMailerHandlerFactory::class;
            case 'pushover':
                return PushoverHandlerFactory::class;
            case 'hipchat':
                return HipChatHandlerFactory::class;
        }

        return null;
    }
}
