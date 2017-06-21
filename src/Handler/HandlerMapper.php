<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use WShafer\PSR11MonoLog\MapperAbstract;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class HandlerMapper extends MapperAbstract
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getFactoryClassName(string $type)
    {
        if (class_exists($type)) {
            return $type;
        }

        switch ($type) {
            case 'stream':
                return StreamHandlerFactory::class;
            case 'rotating':
                return RotatingFileHandlerFactory::class;
            case 'syslog':
                return SyslogHandlerFactory::class;
            case 'errorlog':
                return ErrorLogHandlerFactory::class;
            case 'nativeMailer':
                return NativeMailerHandlerFactory::class;
        }

        return null;
    }
}
