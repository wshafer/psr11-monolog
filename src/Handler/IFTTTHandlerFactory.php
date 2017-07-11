<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\IFTTTHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class IFTTTHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $eventName = (string)  ($options['eventName'] ?? '');
        $secretKey = (string)  ($options['secretKey'] ?? '');
        $level     = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble    = (boolean) ($options['bubble']    ?? true);

        return new IFTTTHandler(
            $eventName,
            $secretKey,
            $level,
            $bubble
        );
    }
}
