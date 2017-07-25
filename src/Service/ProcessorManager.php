<?php

namespace WShafer\PSR11MonoLog\Service;

use WShafer\PSR11MonoLog\ConfigInterface;

class ProcessorManager extends AbstractServiceManager
{
    public function getServiceConfig($id): ConfigInterface
    {
        return $this->config->getProcessorConfig($id);
    }
}
