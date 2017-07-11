<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\AmqpHandler;
use Monolog\Logger;
use PhpAmqpLib\Channel\AMQPChannel;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\ContainerTrait;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\FactoryInterface;

class AmqpHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ContainerTrait;

    public function __invoke(array $options)
    {
        $exchange     = $this->getAmqpExchange($options);
        $exchangeName = (string)  ($options['exchangeName'] ?? 'log');
        $level        = (int)     ($options['level']     ?? Logger::DEBUG);
        $bubble       = (boolean) ($options['bubble']    ?? true);

        return new AmqpHandler(
            $exchange,
            $exchangeName,
            $level,
            $bubble
        );
    }

    /**
     * @param $options
     * @return \AMQPExchange|AMQPChannel
     */
    public function getAmqpExchange($options)
    {
        if (empty($options['exchange'])) {
            throw new MissingConfigException(
                'No exchange service name'
            );
        }

        if (!$this->getContainer()->has($options['exchange'])) {
            throw new MissingServiceException(
                'No exchange service found for :'.$options['exchange']
            );
        }

        return $this->getContainer()->get($options['exchange']);
    }
}
