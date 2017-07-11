<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\SwiftMailerHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\FactoryInterface;

class SwiftMailerHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use SwiftMessageTrait;

    public function __invoke(array $options)
    {
        $mailer  = $this->getMailer($options);
        $message = $this->getSwiftMessage($options);

        $level   = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble  = (boolean) ($options['bubble'] ?? true);

        return new SwiftMailerHandler($mailer, $message, $level, $bubble);
    }

    protected function getMailer($options)
    {
        if (empty($options['mailer'])) {
            throw new MissingConfigException(
                'No mailer service name provided'
            );
        }

        if (!$this->getContainer()->has($options['mailer'])) {
            throw new MissingServiceException(
                'No mailer service found'
            );
        }

        return $this->getContainer()->get($options['mailer']);
    }
}
