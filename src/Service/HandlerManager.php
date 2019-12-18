<?php

namespace WShafer\PSR11MonoLog\Service;

use Monolog\Handler\HandlerInterface;
use WShafer\PSR11MonoLog\ConfigInterface;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\Exception\UnknownServiceException;

class HandlerManager extends AbstractServiceManager
{
    /** @var FormatterManager */
    protected $formatterManager;

    /**
     * @var ProcessorManager
     */
    protected $processorManager;

    public function getServiceConfig($id): ConfigInterface
    {
        return $this->config->getHandlerConfig($id);
    }

    public function hasServiceConfig($id): bool
    {
        return $this->config->hasHandlerConfig($id);
    }

    public function get($id)
    {
        if (array_key_exists($id, $this->services)) {
            return $this->services[$id];
        }

        /** @var HandlerInterface $handler */
        $handler = parent::get($id);

        $config = $this->config->getHandlerConfig($id);

        if (!$config) {
            return $handler;
        }

        $formatter = $config->getFormatter();

        if ($formatter) {
            $handler->setFormatter($this->getFormatter($formatter));
        }

        $processors = $config->getProcessors();
        foreach ($processors as $processorName) {
            $handler->pushProcessor($this->getProcessorManager()->get($processorName));
        }

        return $handler;
    }

    public function setFormatterManager(FormatterManager $manager)
    {
        $this->formatterManager = $manager;
    }

    public function getFormatterManager(): FormatterManager
    {
        if (!$this->formatterManager) {
            throw new MissingServiceException(
                'Unable to get FormatterManager.'
            );
        }

        return $this->formatterManager;
    }

    protected function getFormatter($id)
    {
        if (!$this->getFormatterManager()->has($id)) {
            throw new UnknownServiceException(
                'Unable to locate formatter ' . $id
            );
        }

        return $this->getFormatterManager()->get($id);
    }

    public function setProcessorManager($processorManager)
    {
        $this->processorManager = $processorManager;
    }

    public function getProcessorManager()
    {
        if (!$this->processorManager) {
            throw new MissingServiceException(
                'Unable to get ProcessorManager.'
            );
        }

        return $this->processorManager;
    }
}
