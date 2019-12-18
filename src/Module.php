<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog;

class Module
{
    public function getConfig()
    {
        return [
            'service_manager' => [
                'factories' => [
                    ChannelChanger::class => ChannelChangerFactory::class
                ]
            ]
        ];
    }
}
