<?php

namespace WShafer\PSR11MonoLog;

use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;

trait ClientTrait
{
    use ContainerTrait;

    public function getClient($options)
    {
        if (empty($options['client'])) {
            throw new MissingConfigException(
                'No redis service name found in config'
            );
        }

        if (!$this->getContainer()->has($options['client'])) {
            throw new MissingServiceException(
                'No redis service found for :'.$options['client']
            );
        }

        return $this->getContainer()->get($options['client']);
    }
}
