<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\ZendMonitorHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

/**
 * @codeCoverageIgnore
 *
 * No Zend Server available to test against
 */
class ZendMonitorHandlerFactory implements FactoryInterface
{
    /**
     * @param array $options
     * @return ZendMonitorHandler
     * @throws MissingExtensionException
     */
    public function __invoke(array $options)
    {
        $level  = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble = (bool) ($options['bubble'] ?? true);

        return new ZendMonitorHandler(
            $level,
            $bubble
        );
    }
}
