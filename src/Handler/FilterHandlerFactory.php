<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\FilterHandler;
use WShafer\PSR11MonoLog\HandlerManagerAwareInterface;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\FactoryInterface;

class FilterHandlerFactory implements FactoryInterface, HandlerManagerAwareInterface
{
    use HandlerManagerTrait;

    public function __invoke(array $options)
    {
        $handler        = $this->getHandlerManager()->get($options['handler']);
        $minLevelOrList =            $options['minLevelOrList'] ?? null;
        $maxLevel       =            $options['maxLevel']       ?? null;
        $bubble         = (boolean) ($options['bubble']         ?? true);

        return new FilterHandler(
            $handler,
            $minLevelOrList,
            $maxLevel,
            $bubble
        );
    }
}
