<?php

namespace WShafer\PSR11MonoLog\Service;

use WShafer\PSR11MonoLog\ConfigInterface;

class FormatterManager extends AbstractServiceManager
{
    public function getServiceConfig($id): ConfigInterface
    {
        return $this->config->getFormatterConfig($id);
    }

    public function has($id)
    {
        if (parent::has($id)) {
            return true;
        }

        return $this->config->hasFormatterConfig($id);
    }
}
