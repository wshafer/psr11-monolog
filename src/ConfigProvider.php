<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog;

class ConfigProvider
{
    public function __invoke()
    {
        return require __DIR__.'/../config/monolog.config.php';
    }
}
