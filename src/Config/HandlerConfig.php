<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Config;

class HandlerConfig extends AbstractServiceConfig
{
    public function getFormatters()
    {
        return $this->config['formatters'] ?? [];
    }
}
