<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Config;

use WShafer\PSR11MonoLog\Exception\MissingConfigException;

class HandlerConfig extends AbstractServiceConfig
{
    public function getFormatter()
    {
        return $this->config['formatter'] ?? null;
    }
}
