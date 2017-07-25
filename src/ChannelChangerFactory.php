<?php

namespace WShafer\PSR11MonoLog;

use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Config\MainConfigFactory;
use WShafer\PSR11MonoLog\Formatter\FormatterMapper;
use WShafer\PSR11MonoLog\Processor\ProcessorMapper;
use WShafer\PSR11MonoLog\Service\FormatterManager;
use WShafer\PSR11MonoLog\Service\HandlerManager;
use WShafer\PSR11MonoLog\Service\ProcessorManager;

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
        $factory = new MainConfigFactory();
        $this->config = $factory($container);
        return $this->config;
    }

    public function getHandlerManager(ContainerInterface $container)
    {
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
        $config = $this->getMainConfig($container);
        $this->processManager = new ProcessorManager(
            $config,
            new ProcessorMapper(),
            $container
        );

        return $this->processManager;
    }
}
