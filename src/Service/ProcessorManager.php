<?php

namespace WShafer\PSR11MonoLog\Service;

use WShafer\PSR11MonoLog\ConfigInterface;

class ProcessorManager extends AbstractServiceManager
{
    const INTERFACE = \stdClass::class;

    public function getServiceConfig($id): ConfigInterface
    {
        return $this->config->getProcessorConfig($id);
    }
}
