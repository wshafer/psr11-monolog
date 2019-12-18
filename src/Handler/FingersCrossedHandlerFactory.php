<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\FingersCrossedHandler;
use WShafer\PSR11MonoLog\HandlerManagerAwareInterface;
use WShafer\PSR11MonoLog\HandlerManagerTrait;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\ContainerTrait;
use WShafer\PSR11MonoLog\FactoryInterface;

class FingersCrossedHandlerFactory implements FactoryInterface, HandlerManagerAwareInterface, ContainerAwareInterface
{
    use ContainerTrait;
    use HandlerManagerTrait;

    public function __invoke(array $options)
    {
        $handler            = $this->getHandlerManager()->get($options['handler']);
        $activationStrategy = $this->getActivationStrategy($options);
        $bufferSize         = (int)     ($options['bufferSize']    ?? 0);
        $bubble             = (bool) ($options['bubble']        ?? true);
        $stopBuffering      = (bool) ($options['stopBuffering'] ?? true);
        $passthruLevel      =            $options['passthruLevel'] ?? null;

        return new FingersCrossedHandler(
            $handler,
            $activationStrategy,
            $bufferSize,
            $bubble,
            $stopBuffering,
            $passthruLevel
        );
    }

    protected function getActivationStrategy($options)
    {
        $activationStrategy = $options['activationStrategy'] ?? null;

        if (!$activationStrategy) {
            return null;
        }

        if ($this->getContainer()->has($activationStrategy)) {
            return $this->getContainer()->get($activationStrategy);
        }

        return $activationStrategy;
    }
}
