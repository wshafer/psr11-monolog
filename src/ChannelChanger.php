<?php

namespace WShafer\PSR11MonoLog\Service;

use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\Exception\UnknownServiceException;

class ChannelChanger implements ContainerInterface
{
    /** @var LoggerInterface[] */
    protected $channels = [];

    /** @var MainConfig */
    protected $config;

    /** @var ContainerInterface */
    protected $handlerManager;

    /** @var ContainerInterface */
    protected $processorManager;

    public function __construct(
        MainConfig $config,
        ContainerInterface $handlerManager,
        ContainerInterface $processorManager
    ) {
        $this->config = $config;
        $this->handlerManager = $handlerManager;
        $this->processorManager = $processorManager;
    }

    public function get($id)
    {
        if (!empty($this->channels[$id])
            && $this->channels[$id] instanceof LoggerInterface
        ) {
            return $this->channels[$id];
        }

        if (!$this->has($id)) {
            throw new UnknownServiceException(
                'Unable to locate channel '.$id
            );
        }

        $config = $this->config->getChannelConfig($id);

        $channel = new Logger($id);

        $handlersToUse = $config->getHandlers();

        foreach ($handlersToUse as $handlerToUse) {
            $handler = $this->getHandler($handlerToUse);
            $channel->pushHandler($handler);
        }

        $processorsToUse = $config->getProcessors();

        foreach ($processorsToUse as $processorToUse) {
            $processor = $this->getProcessor($processorToUse);
            $channel->pushProcessor($processor);
        }

        return $this->channels[$id];
    }

    public function has($id)
    {
        return $this->config->hasChannelConfig($id);
    }

    protected function getHandler($id)
    {
        if (!$this->handlerManager->has($id)) {
            throw new UnknownServiceException(
                'Unable to locate processor '.$id
            );
        }

        return $this->handlerManager->get($id);
    }

    protected function getProcessor($id)
    {
        if (!$this->processorManager->has($id)) {
            throw new UnknownServiceException(
                'Unable to locate processor '.$id
            );
        }

        return $this->processorManager->get($id);
    }
}
