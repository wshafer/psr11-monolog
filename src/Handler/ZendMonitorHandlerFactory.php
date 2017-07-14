<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

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
    public function __invoke(array $options)
    {
        $level  = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble = (boolean) ($options['bubble'] ?? true);

        return new ZendMonitorHandler(
            $level,
            $bubble
        );
    }
}
