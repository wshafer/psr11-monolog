<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Processor;

use Monolog\Processor\WebProcessor;
use WShafer\PSR11MonoLog\ContainerAwareInterface;
use WShafer\PSR11MonoLog\ContainerTrait;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\FactoryInterface;

class WebProcessorFactory implements FactoryInterface, ContainerAwareInterface
{
    use ContainerTrait;

    public function __invoke(array $options)
    {
        $serverData     = $this->getServerDataService($options);
        $extraFields    = (array) ($options['extraFields'] ?? null);

        return new WebProcessor(
            $serverData,
            $extraFields
        );
    }

    public function getServerDataService(array $options)
    {
        if (empty($options['serverData'])) {
            return null;
        }

        if (is_array($options['serverData'])
            || $options['serverData'] instanceof \ArrayAccess
        ) {
            return $options['serverData'];
        }

        if (!$this->getContainer()->has($options['serverData'])) {
            throw new MissingServiceException(
                'No serverData service found'
            );
        }

        return $this->getContainer()->get($options['serverData']);
    }
}
