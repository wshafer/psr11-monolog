<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\FactoryInterface;

class RotatingFileHandlerFactory implements FactoryInterface
{
    public function __invoke(array $options)
    {
        $filename       = (string)  ($options['filename']       ?? '');
        $maxFiles       = (int)     ($options['maxFiles']       ?? 0);
        $level          = (int)     ($options['level']          ?? Logger::DEBUG);
        $bubble         = (bool) ($options['bubble']         ?? true);
        $filePermission = (int)     ($options['filePermission'] ?? null);
        $useLocking     = (bool) ($options['useLocking']     ?? false);

        return new RotatingFileHandler($filename, $maxFiles, $level, $bubble, $filePermission, $useLocking);
    }
}
