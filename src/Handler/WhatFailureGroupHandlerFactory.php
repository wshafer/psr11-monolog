<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\WhatFailureGroupHandler;

class WhatFailureGroupHandlerFactory extends GroupHandlerFactory
{
    public function __invoke(array $options)
    {
        $handlers = $this->getHandlers($options);
        $bubble   = (bool) ($options['bubble'] ?? true);

        return new WhatFailureGroupHandler(
            $handlers,
            $bubble
        );
    }
}
