<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SamplingHandler;
use WShafer\PSR11MonoLog\Exception\InvalidConfigException;
use WShafer\PSR11MonoLog\HandlerManagerAwareInterface;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\FactoryInterface;

class SamplingHandlerFactory implements FactoryInterface, HandlerManagerAwareInterface
{
    use HandlerManagerTrait;

    public function __invoke(array $options)
    {
        $handler = $this->getHandlerManager()->get($options['handler']);
        $factor  = (int) ($options['factor'] ?? null);

        if (empty($factor)) {
            throw new InvalidConfigException(
                'Factor is missing or is less then 1'
            );
        }

        return new SamplingHandler(
            $handler,
            $factor
        );
    }
}
