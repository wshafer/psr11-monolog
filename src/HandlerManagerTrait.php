<?php

namespace WShafer\PSR11MonoLog;

use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\Service\HandlerManager;

trait HandlerManagerTrait
{
    /** @var HandlerManager */
    protected $handlerManager;

    public function getHandlerManager(): HandlerManager
    {
        if (!$this->handlerManager) {
            throw new MissingServiceException("Handler Manager service not set");
        }

        return $this->handlerManager;
    }

    public function setHandlerManager(HandlerManager $handlerManager)
    {
        $this->handlerManager = $handlerManager;
    }
}
