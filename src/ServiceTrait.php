<?php

namespace WShafer\PSR11MonoLog;

use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;

trait ServiceTrait
{
    use ContainerTrait;

    public function getService($name)
    {
        if (empty($name)) {
            throw new MissingConfigException(
                'No service name found in config'
            );
        }

        if (!$this->getContainer()->has($name)) {
            throw new MissingServiceException(
                'No service found for :'.$name
            );
        }

        return $this->getContainer()->get($name);
    }
}
