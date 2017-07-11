<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Monolog\Handler\MandrillHandler;
use Monolog\Logger;

class MandrillHandlerFactory
{
    use SwiftMessageTrait;

    public function __invoke(array $options)
    {
        $apiKey  = (string)  ($options['apiKey']  ?? '');
        $message = $this->getSwiftMessage($options);
        $level   = (int)     ($options['level']   ?? Logger::DEBUG);
        $bubble  = (boolean) ($options['bubble']  ?? true);

        return new MandrillHandler(
            $apiKey,
            $message,
            $level,
            $bubble
        );
    }
}
