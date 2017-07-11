<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\CubeHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class CubeHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $url    = (string)  ($options['url']    ?? '');
        $level  = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble = (boolean) ($options['bubble'] ?? true);

        return new CubeHandler(
            $url,
            $level,
            $bubble
        );
    }
}
