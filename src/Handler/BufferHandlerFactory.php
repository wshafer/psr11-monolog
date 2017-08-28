<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\BufferHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\HandlerManagerAwareInterface;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\FactoryInterface;

class BufferHandlerFactory implements FactoryInterface, HandlerManagerAwareInterface
{
    use HandlerManagerTrait;

    public function __invoke(array $options)
    {
        $handler          = $this->getHandlerManager()->get($options['handler']);
        $bufferLimit      = (int)     ($options['bufferLimit']     ?? 0);
        $level            = (int)     ($options['level']           ?? Logger::DEBUG);
        $bubble           = (boolean) ($options['bubble']          ?? true);
        $flushOnOverflow  = (boolean) ($options['flushOnOverflow'] ?? true);

        return new BufferHandler(
            $handler,
            $bufferLimit,
            $level,
            $bubble,
            $flushOnOverflow
        );
    }
}
