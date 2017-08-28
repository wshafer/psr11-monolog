<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\GroupHandler;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\HandlerManagerAwareInterface;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\FactoryInterface;

class GroupHandlerFactory implements FactoryInterface, HandlerManagerAwareInterface
{
    use HandlerManagerTrait;

    public function __invoke(array $options)
    {
        $handlers = $this->getHandlers($options);
        $bubble   = (boolean) ($options['bubble'] ?? true);

        return new GroupHandler(
            $handlers,
            $bubble
        );
    }

    protected function getHandlers($options)
    {
        $handlers = $options['handlers'] ?? [];

        if (empty($handlers) || !is_array($handlers)) {
            throw new MissingConfigException(
                "No handlers specified"
            );
        }

        $return = [];

        foreach ($handlers as $handler) {
            $return[] = $this->getHandlerManager()->get($handler);
        }

        return $return;
    }
}
