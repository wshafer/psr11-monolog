<?php

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Logger;

trait ConfigTrait
{
    protected function getConfigArray()
    {
        return [
            'monolog' => [
                'formatters' => [
                    'formatterOne' => [
                        'type' => 'LineFormatter',
                        'options' => [
                            'format' => "%datetime% > %level_name% > %message% %context% %extra%\n",
                            'dateFormat' => 'Y n j, g:i a',
                        ],
                    ],

                    'formatterTwo' => [
                        'type' => 'LineFormatter',
                        'options' => [
                            'format' => "[%datetime%][%level_name%] %message% %context% %extra%\n",
                            'dateFormat' => 'Y n j, g:i a',
                        ],
                    ],
                ],

                'handlers' => [
                    'handlerOne' => [
                        'type' => 'StreamHandler',
                        'formatter' => 'formatterOne',
                        'options' => [
                            'stream' => '/tmp/logOne.txt',
                            'level' => Logger::ERROR,
                            'bubble' =>  true,
                            'filePermission' => 755,
                            'useLocking' => true
                        ],
                    ],

                    'handlerTwo' => [
                        'type' => 'StreamHandler',
                        'formatter' => 'formatterOne',
                        'options' => [
                            'stream' => '/tmp/logOne.txt',
                            'level' => Logger::ERROR,
                            'bubble' =>  true,
                            'filePermission' => 755,
                            'useLocking' => true
                        ],
                    ],
                ],

                'processors' => [
                    'processorOne' => [
                        'type' => 'introspection',
                        'options' => [
                            'dateFormat' => 'Y n j, g:i a',
                        ],
                    ],
                ],

                'channels' => [
                    'myChannel' => [
                        'handlers' => [
                            'handlerOne',
                            'handlerTwo'
                        ],

                        'processors' => [
                            'serviceOne',
                            'serviceTwo'
                        ],
                    ],
                ],
            ],
        ];
    }
}
