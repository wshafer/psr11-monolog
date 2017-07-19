<?php

namespace WShafer\PSR11MonoLog\Service;

use Monolog\Handler\HandlerInterface;
use WShafer\PSR11MonoLog\ConfigInterface;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\Exception\UnknownServiceException;

class HandlerManager extends AbstractServiceManager
{
    const INTERFACE = HandlerInterface::class;

    /** @var FormatterManager */
    protected $formatterManager;

    public function getServiceConfig($id): ConfigInterface
    {
        return $this->config->getHandlerConfig($id);
    }

    public function get($id)
    {
        $interface = self::INTERFACE;

        if (key_exists($id, $this->services)
            && $this->services[$id] instanceof $interface
        ) {
            return $this->services[$id];
        }

        $config = $this->config->getHandlerConfig($id);

        /** @var HandlerInterface $handler */
        $handler = parent::get($id);

        $formatter= $config->getFormatter();

        if ($formatter) {
            $handler->setFormatter($this->getFormatter($formatter));
        }

        return $handler;
    }

    public function setFormatterManager(FormatterManager $manager)
    {
        $this->formatterManager = $manager;
    }

    public function getFormatterManager() : FormatterManager
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
        if (!$this->formatterManager->has($id)) {
            throw new UnknownServiceException(
                'Unable to locate formatter '.$id
            );
        }

        return $this->formatterManager->get($id);
    }
}
