<?php
declare(strict_types=1);

return [
    'dependencies' => [
        'factories'  => [
            'WShafer\PSR11MonoLog\ChannelChanger'
                => \WShafer\PSR11MonoLog\Service\ChannelChangerFactory::class,
        ]
    ]
];
