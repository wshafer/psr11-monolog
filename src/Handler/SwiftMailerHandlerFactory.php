<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\StreamHandler;
use Monolog\Handler\SwiftMailerHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\FactoryInterface;

class SwiftMailerHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    protected $container;

    public function __invoke(array $options)
    {
        $mailer = $this->getMailer($options);
        $message = $this->getSwiftMessage($options);
        $level = $options['level'] ?? Logger::DEBUG;
        $bubble = (boolean) $options['bubble'] ?? true;

        return new SwiftMailerHandler($mailer, $message, $level, $bubble);
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
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

    protected function getSwiftMessage($options)
    {
        if (empty($options['message'])) {
            throw new MissingConfigException(
                'No message service name or callback provided'
            );
        }

        if (is_callable($options['message'])) {
            return $options['message'];
        }

        if (!$this->getContainer()->has($options['message'])) {
            throw new MissingServiceException(
                'No Message service found'
            );
        }

        return $this->getContainer()->get($options['message']);
    }
}
