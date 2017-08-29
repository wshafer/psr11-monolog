<?php

namespace WShafer\PSR11MonoLog\Handler;

use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\MissingServiceException;
use WShafer\PSR11MonoLog\ServiceTrait;

trait SwiftMessageTrait
{
    use ServiceTrait;

    /**
     * @param $options
     * @return callable|\Swift_Message
     */
    public function getSwiftMessage($options)
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
