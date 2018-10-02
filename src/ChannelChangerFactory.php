<?php

namespace WShafer\PSR11MonoLog;

use ArrayObject;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\Formatter\FormatterMapper;
use WShafer\PSR11MonoLog\Handler\HandlerMapper;
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
        return new MainConfig($this->getConfigArray($container));
    }

    protected function getConfigArray(ContainerInterface $container)
    {
        // Symfony config is parameters. //
        if (method_exists($container, 'getParameter')
            && method_exists($container, 'hasParameter')
            && $container->hasParameter('monolog')
        ) {
            return ['monolog' => $container->getParameter('monolog')];
        }

        // Zend uses config key
        if ($container->has('config')) {
            return $this->getZendConfigArray($container);
        }

        // Slim Config comes from "settings"
        if ($container->has('settings')) {
            return ['monolog' => $container->get('settings')['monolog']];
        }

        return [];
    }

    protected function getZendConfigArray(ContainerInterface $container)
    {
        $config = $container->get('config');
        if ($config instanceof ArrayObject) {
            $config = $config->getArrayCopy();
        }

        return $config;
    }

    public function getHandlerManager(ContainerInterface $container)
    {
        $config = $this->getMainConfig($container);
        $this->handlerManager = new HandlerManager(
            $config,
            new HandlerMapper(),
            $container
        );

        $this->handlerManager->setFormatterManager($this->getFormatterManager($container));
        $this->handlerManager->setProcessorManager($this->getProcessorManager($container));
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
