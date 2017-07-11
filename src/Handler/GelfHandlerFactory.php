<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Gelf\PublisherInterface;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\ContainerTrait;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\FactoryInterface;

class GelfHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ContainerTrait;

    public function __invoke(array $options)
    {
        $publisher = $this->getPublisher($options);
        $level     = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble    = (boolean) ($options['bubble']    ?? true);

        return new GelfHandler(
            $publisher,
            $level,
            $bubble
        );
    }

    /**
     * @param $options
     * @return PublisherInterface
     */
    public function getPublisher($options)
    {
        if (empty($options['publisher'])) {
            throw new MissingConfigException(
                'No exchange service name'
            );
        }

        if (!$this->getContainer()->has($options['publisher'])) {
            throw new MissingServiceException(
                'No publisher service found for :'.$options['publisher']
            );
        }

        return $this->getContainer()->get($options['publisher']);
    }
}
