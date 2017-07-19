<?php

namespace WShafer\PSR11MonoLog\Service;

use Monolog\Formatter\FormatterInterface;
use WShafer\PSR11MonoLog\ConfigInterface;

class FormatterManager extends AbstractServiceManager
{
    const INTERFACE = FormatterInterface::class;

    public function getServiceConfig($id): ConfigInterface
    {
        return $this->config->getFormatterConfig($id);
    }
}
