<?php

namespace WShafer\PSR11MonoLog\Service;

use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Config\MainConfigFactory;
use WShafer\PSR11MonoLog\Formatter\FormatterMapper;
use WShafer\PSR11MonoLog\Processor\ProcessorMapper;

class ChannelChangerFactory
{
    protected $config = null;

    protected $handlerManager = null;

    protected $processManager = null;

    protected $formatterManager = null;

    public function __invoke(ContainerInterface $container)
    {
        $config = $this->getMainConfig($container);
        $handlerManager = $this->getHandlerManager($container);
        $processorManager = $this->getProcessorManager($container);

        return new ChannelChanger(
            $config,
            $handlerManager,
            $processorManager
        );
    }

    public function getMainConfig(ContainerInterface $container)
    {
        if (!$this->config) {
            $factory = new MainConfigFactory();
            $this->config = $factory($container);
        }

        return $this->config;
    }

    public function getHandlerManager(ContainerInterface $container)
    {
        if ($this->handlerManager) {
            return $this->handlerManager;
        }

        $config = $this->getMainConfig($container);
        $this->handlerManager = new HandlerManager(
            $config,
            new FormatterMapper(),
            $container
        );

        $this->handlerManager->setFormatterManager($this->getFormatterManager($container));
        return $this->handlerManager;
    }

    public function getFormatterManager(ContainerInterface $container)
    {
        if (!$this->formatterManager) {
            return $this->formatterManager;
        }

        $config = $this->getMainConfig($container);
        $this->formatterManager = new FormatterManager(
            $config,
            new FormatterMapper(),
            $container
        );

        return $this->formatterManager;
    }

    public function getProcessorManager(ContainerInterface $container)
    {
        if (!$this->processManager) {
            return $this->processManager;
        }

        $config = $this->getMainConfig($container);
        $this->processManager = new ProcessorManager(
            $config,
            new ProcessorMapper(),
            $container
        );

        return $this->processManager;
    }
}
