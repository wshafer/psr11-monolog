<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\RavenHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\ContainerTrait;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\FactoryInterface;

class RavenHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ContainerTrait;

    public function __invoke(array $options)
    {
        $client = $this->getClient($options);
        $level  = (int)     ($options['level']  ?? Logger::DEBUG);
        $bubble = (boolean) ($options['bubble'] ?? true);

        return new RavenHandler(
            $client,
            $level,
            $bubble
        );
    }

    /**
     * @param $options
     * @return \Raven_Client
     */
    public function getClient($options)
    {
        if (empty($options['client'])) {
            throw new MissingConfigException(
                'No Raven client service name'
            );
        }

        if (!$this->getContainer()->has($options['client'])) {
            throw new MissingServiceException(
                'No client service found for :'.$options['client']
            );
        }

        return $this->getContainer()->get($options['client']);
    }
}
