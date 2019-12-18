<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\OverflowHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\HandlerManagerAwareInterface;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\FactoryInterface;

class OverflowHandlerFactory implements FactoryInterface, HandlerManagerAwareInterface
{
    use HandlerManagerTrait;

    public function __invoke(array $options)
    {
        $handler = $this->getHandlerManager()->get($options['handler']);
        $thresholdMap = [
            Logger::DEBUG => $options['thresholdMap']['debug'] ?? 0,
            Logger::INFO => $options['thresholdMap']['info'] ?? 0,
            Logger::NOTICE => $options['thresholdMap']['notice'] ?? 0,
            Logger::WARNING => $options['thresholdMap']['warning'] ?? 0,
            Logger::ERROR => $options['thresholdMap']['error'] ?? 0,
            Logger::CRITICAL => $options['thresholdMap']['critical'] ?? 0,
            Logger::ALERT => $options['thresholdMap']['alert'] ?? 0,
            Logger::EMERGENCY => $options['thresholdMap']['emergency'] ?? 0,
        ];

        $level  = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble = (boolean) ($options['bubble'] ?? true);

        return new OverflowHandler(
            $handler,
            $thresholdMap,
            $level,
            $bubble
        );
    }
}
