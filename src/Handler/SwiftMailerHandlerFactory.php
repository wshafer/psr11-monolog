<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SwiftMailerHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\FactoryInterface;

class SwiftMailerHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use SwiftMessageTrait;

    public function __invoke(array $options)
    {
        $mailer  = $this->getService($options['mailer'] ?? null);
        $message = $this->getSwiftMessage($options);

        $level   = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble  = (boolean) ($options['bubble'] ?? true);

        return new SwiftMailerHandler($mailer, $message, $level, $bubble);
    }
}
