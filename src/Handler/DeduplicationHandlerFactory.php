<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\DeduplicationHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\HandlerManagerAwareInterface;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\FactoryInterface;

class DeduplicationHandlerFactory implements FactoryInterface, HandlerManagerAwareInterface
{
    use HandlerManagerTrait;

    public function __invoke(array $options)
    {
        $handler            = $this->getHandlerManager()->get($options['handler']);
        $deduplicationStore =            $options['deduplicationStore'] ?? null;
        $deduplicationLevel = (int)     ($options['deduplicationLevel'] ?? Logger::ERROR);
        $time               = (int)     ($options['time']               ?? 60);
        $bubble             = (boolean) ($options['bubble']             ?? true);

        return new DeduplicationHandler(
            $handler,
            $deduplicationStore,
            $deduplicationLevel,
            $time,
            $bubble
        );
    }
}
