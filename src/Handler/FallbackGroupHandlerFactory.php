<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\FallbackGroupHandler;

class FallbackGroupHandlerFactory extends GroupHandlerFactory
{
    public function __invoke(array $options)
    {
        $handlers = $this->getHandlers($options);
        $bubble   = (boolean) ($options['bubble'] ?? true);

        return new FallbackGroupHandler(
            $handlers,
            $bubble
        );
    }
}
