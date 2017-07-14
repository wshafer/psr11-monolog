<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\PHPConsoleHandler;
use Monolog\Logger;
use PhpConsole\Connector;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\ContainerTrait;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\FactoryInterface;

class PHPConsoleHandlerFactory implements FactoryInterface, ContainerAwareInterface
{
    use ContainerTrait;

    public function __invoke(array $options)
    {
        $consoleOptions = (array)   ($options['options'] ?? []);
        $connector      = $this->getConnector($options);
        $level          = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble         = (boolean) ($options['bubble']  ?? true);

        return new PHPConsoleHandler(
            $consoleOptions,
            $connector,
            $level,
            $bubble
        );
    }

    /**
     * @param $options
     * @return Connector
     */
    public function getConnector($options)
    {
        if (empty($options['connector'])) {
            return null;
        }

        if (!$this->getContainer()->has($options['connector'])) {
            throw new MissingServiceException(
                'No connector service found for :'.$options['connector']
            );
        }

        return $this->getContainer()->get($options['connector']);
    }
}
