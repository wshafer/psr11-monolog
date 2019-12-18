<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog;

use WShafer\PSR11MonoLog\Service\HandlerManager;

interface HandlerManagerAwareInterface
{
    public function getHandlerManager(): HandlerManager;
    public function setHandlerManager(HandlerManager $container);
}
