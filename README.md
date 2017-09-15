[![codecov](https://codecov.io/gh/wshafer/psr11-monolog/branch/master/graph/badge.svg)](https://codecov.io/gh/wshafer/psr11-monolog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wshafer/psr11-monolog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wshafer/psr11-monolog/?branch=master)
[![Build Status](https://travis-ci.org/wshafer/psr11-monolog.svg?branch=master)](https://travis-ci.org/wshafer/psr11-monolog)
# PSR-11 Monolog

[Monolog](https://github.com/Seldaek/monolog) Factories for PSR-11

#### Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Containers](#containers)
    - [Pimple](#pimple-example)
    - [Zend Service Manager](#zend-service-manager)
- [Frameworks](#frameworks)
    - [Zend Expressive](#zend-expressive)
    - [Zend Framework 3](#zend-framework-3)
    - [Slim](#slim)
- [Configuration](#configuration)
    - [Minimal Configuration](#minimal-configuration)
        - [Example](#minimal-example)
    - [Full Configuration](#full-configuration)
        - [Full Example](#full-example)
    - [Channels](#channels)
    - [Handlers](#handlers)
        - [Log to files and syslog](#log-to-files-and-syslog)
            - [StreamHandler](#streamhandler)
            - [RotatingFileHandler](#rotatingfilehandler)
            - [SyslogHandler](#sysloghandler)
            - [ErrorLogHandler](#errorloghandler)
        - [Send alerts and emails](#send-alerts-and-emails)
            - [NativeMailerHandler](#nativemailerhandler)
            - [SwiftMailerHandler](#swiftmailerhandler)
            - [PushoverHandler](#pushoverhandler)
            - [HipChatHandler](#hipchathandler)
            - [FlowdockHandler](#flowdockhandler)
            - [SlackbotHandler](#slackbothandler)
            - [SlackWebhookHandler](#slackwebhookhandler)
            - [SlackHandler](#slackhandler)
            - [MandrillHandler](#mandrillhandler)
            - [FleepHookHandler](#fleephookhandler)
            - [IFTTTHandler](#ifttthandler)
        - [Log specific servers and networked logging](#log-specific-servers-and-networked-logging)
            - [SocketHandler](#sockethandler)
            - [AmqpHandler](#amqphandler)
            - [GelfHandler](#gelfhandler)
            - [CubeHandler](#cubehandler)
            - [RavenHandler](#ravenhandler)
            - [ZendMonitorHandler](#zendmonitorhandler)
            - [NewRelicHandler](#newrelichandler)
            - [LogglyHandler](#logglyhandler)
            - [RollbarHandler](#rollbarhandler)
            - [SyslogUdpHandler](#syslogudphandler)
            - [LogEntriesHandler](#logentrieshandler)
        - [Logging in development](#logging-in-development)
            - [FirePHPHandler](#firephphandler)
            - [ChromePHPHandler](#chromephphandler)
            - [BrowserConsoleHandler](#browserconsolehandler)
            - [PHPConsoleHandler](#phpconsolehandler)
        - [Log to databases](#log-to-databases)
            - [RedisHandler](#redishandler)
            - [MongoDBHandler](#mongodbhandler)
            - [CouchDBHandler](#couchdbhandler)
            - [DoctrineCouchDBHandler](#doctrinecouchdbhandler)
            - [ElasticSearchHandler](#elasticsearchhandler)
         - [Wrappers / Special Handlers](#wrappers--special-handlers)
            - [FingersCrossedHandler](#fingerscrossedhandler)
            - [DeduplicationHandler](#deduplicationhandler)
            - [WhatFailureGroupHandler](#whatfailuregrouphandler)
            - [BufferHandler](#bufferhandler)
            - [GroupHandler](#grouphandler)
            - [FilterHandler](#filterhandler)
            - [SamplingHandler](#samplinghandler)
            - [NullHandler](#nullhandler)
            - [PsrHandler](#psrhandler)
            - [TestHandler](#testhandler)
    - [Formatters](#formatters)
        - [LineFomatter](#linefomatter)
        - [HtmlFormatter](#htmlformatter)
        - [NormalizerFormatter](#normalizerformatter)
        - [ScalarFormatter](#scalarformatter)
        - [JsonFormatter](#jsonformatter)
        - [WildfireFormatter](#wildfireformatter)
        - [ChromePHPFormatter](#chromephpformatter)
        - [GelfMessageFormatter](#gelfmessageformatter)
        - [LogstashFormatter](#logstashformatter)
        - [ElasticaFormatter](#elasticaformatter)
        - [LogglyFormatter](#logglyformatter)
        - [FlowdockFormatter](#flowdockformatter)
        - [MongoDBFormatter](#mongodbformatter)
    - [Processors](#processors)
        - [PsrLogMessageProcessor](#psrlogmessageprocessor)
        - [IntrospectionProcessor](#introspectionprocessor)
        - [WebProcessor](#webprocessor)
        - [MemoryUsageProcessor](#memoryusageprocessor)
        - [MemoryPeakUsageProcessor](#memorypeakusageprocessor)
        - [ProcessIdProcessor](#processidprocessor)
        - [UidProcessor](#uidprocessor)
        - [GitProcessor](#gitprocessor)
        - [MercurialProcessor](#mercurialprocessor)
        - [TagProcessor](#tagprocessor)
- [Upgrades](#upgrades)    
    - [Version 1 to version 2](#version-1-to-version-2)

# Installation

```bash
composer require wshafer/psr11-monolog
```

# Usage

```php
<?php

# Get the Channel Changer
$channel = $container->get('my-channel');

# Write to log
$channel->debug('Hi There');
```

Additional info can be found in the [documentation](https://github.com/Seldaek/monolog/blob/master/README.md)

# Containers
Any PSR-11 container wil work.  In order to do that you will need to add configuration
and register a new service that points to `WShafer\PSR11MonoLog\MonologFactory` 

Below are some specific container examples to get you started

## Pimple
```php
// Create Container
$container = new \Xtreamwayz\Pimple\Container([
    // Logger using the default keys.
    'logger' => new \WShafer\PSR11MonoLog\MonologFactory(),
    
    // Another logger using a different channel configuration
    'other' => function($c) {
        return \WShafer\PSR11MonoLog\MonologFactory::channelTwo($c);
    },

    'config' => [
        'monolog' => [
            'handlers' => [
                // At the bare minimum you must include a default handler config.
                // Otherwise log entries will be sent to the void.
                'default' => [
                    'type' => 'stream',
                    'options' => [
                        'stream' => '/var/log/some-log-file.txt',
                    ],
                ],
                
                // Another Handler
                'myOtherHandler' => [
                    'type' => 'stream',
                    'options' => [
                        'stream' => '/var/log/someother-log-file.txt',
                    ],
                ],
            ],
            
            'channels' => [
                // Configure a second channel
                'channelTwo' => [
                    'handlers' => [
                        'myOtherHandler',
                    ],
                ],    
            ],
        ],
    ],
]);

// Get the default channel

/** @var \Monolog\Logger $defaultChannel */
$defaultChannel = $container->get('logger');

// Write to the default channel
$defaultChannel->debug('Write to log');


// Get the second channel

/** @var \Monolog\Logger $channelTwo */
$channelTwo = $container->get('logger');

// Write to the second channel
$channelTwo->debug('Write to log');

```

## Zend Service Manager

```php
<?php
// Create the container and define the services you'd like to use
$container = new \Zend\ServiceManager\ServiceManager([
    'factories' => [
        // Logger using the default keys.
        'logger' => \WShafer\PSR11MonoLog\MonologFactory::class,
        
        // Another logger using a different channel configuration
        'channelTwo' => [\WShafer\PSR11MonoLog\MonologFactory::class, 'channelTwo']
    ]
]);

$container->setService(
    'config',
    [
        'monolog' => [
            'handlers' => [
                // At the bare minimum you must include a default handler config.
                // Otherwise log entries will be sent to the void.
                'default' => [
                    'type' => 'stream',
                    'options' => [
                        'stream' => '/var/log/some-log-file.txt',
                    ],
                ],
                
                // Another Handler
                'myOtherHandler' => [
                    'type' => 'stream',
                    'options' => [
                        'stream' => '/var/log/someother-log-file.txt',
                    ],
                ],
            ],
            
            'channels' => [
                // Configure a second channel
                'channelTwo' => [
                    'handlers' => [
                        'myOtherHandler',
                    ],
                ],    
            ],
        ],
    ]
);

// Get the default channel

/** @var \Monolog\Logger $defaultChannel */
$defaultChannel = $container->get('logger');

// Write to the default channel
$defaultChannel->debug('Write to log');


// Get the second channel

/** @var \Monolog\Logger $channelTwo */
$channelTwo = $container->get('logger');

// Write to the second channel
$channelTwo->debug('Write to log');
```

# Frameworks
Any framework that use a PSR-11 should work fine.   Below are some specific framework examples to get you started

## Zend Expressive
You'll need to add configuration and register the services you'd like to use.  There are number of ways to do that
but the recommended way is to create a new config file `config/autoload/monolog.global.php`

### Configuration
config/autoload/monolog.global.php
```php
<?php
return [
    'dependencies' => [
        'factories' => [
            // Logger using the default keys.
            'logger' => \WShafer\PSR11MonoLog\MonologFactory::class,
            
            // Another logger using a different channel configuration
            'channelTwo' => [\WShafer\PSR11MonoLog\MonologFactory::class, 'channelTwo']
        ]
    ],
    
    'monolog' => [
        'handlers' => [
            // At the bare minimum you must include a default handler config.
            // Otherwise log entries will be sent to the void.
            'default' => [
                'type' => 'stream',
                'options' => [
                    'stream' => '/var/log/some-log-file.txt',
                ],
            ],
            
            // Another Handler
            'myOtherHandler' => [
                'type' => 'stream',
                'options' => [
                    'stream' => '/var/log/someother-log-file.txt',
                ],
            ],
        ],
        
        'channels' => [
            // Configure a second channel
            'channelTwo' => [
                'handlers' => [
                    'myOtherHandler',
                ],
            ],    
        ],
    ],
];
```

## Zend Framework 3
You'll need to add configuration and register the services you'd like to use.  There are number of ways to do that
but the recommended way is to create a new config file `config/autoload/monolog.global.php`

### Configuration
config/autoload/monolog.global.php
```php
<?php
return [
    'service_manager' => [
        'factories' => [
            // Logger using the default keys.
            'logger' => \WShafer\PSR11MonoLog\MonologFactory::class,
            
            // Another logger using a different channel configuration
            'channelTwo' => [\WShafer\PSR11MonoLog\MonologFactory::class, 'channelTwo']
        ]
    ],
    
    'monolog' => [
        'handlers' => [
            // At the bare minimum you must include a default handler config.
            // Otherwise log entries will be sent to the void.
            'default' => [
                'type' => 'stream',
                'options' => [
                    'stream' => '/var/log/some-log-file.txt',
                ],
            ],
            
            // Another Handler
            'myOtherHandler' => [
                'type' => 'stream',
                'options' => [
                    'stream' => '/var/log/someother-log-file.txt',
                ],
            ],
        ],
        
        'channels' => [
            // Configure a second channel
            'channelTwo' => [
                'handlers' => [
                    'myOtherHandler',
                ],
            ],    
        ],
    ],
];
```

### Module Config
If you're not using the [Zend Component Installer](https://github.com/zendframework/zend-component-installer) you will 
also need to register the Module.

config/modules.config.php (ZF 3 skeleton)
```php
<?php

return [
    // ... Previously registered modules here
    'WShafer\\PSR11MonoLog',
];
```

config/application.config.php (ZF 2 skeleton)
```php
<?php

return [
    'modules' => [
        // ... Previously registered modules here
        'WShafer\\PSR11MonoLog',
    ]
];
```

## Slim

public/index.php
```php
<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

// Add Configuration
$config = [
    'settings' => [
        'monolog' => [
            'handlers' => [
                // At the bare minimum you must include a default handler config.
                // Otherwise log entries will be sent to the void.
                'default' => [
                    'type' => 'stream',
                    'options' => [
                        'stream' => '/var/log/some-log-file.txt',
                    ],
                ],
                
                // Another Handler
                'myOtherHandler' => [
                    'type' => 'stream',
                    'options' => [
                        'stream' => '/var/log/someother-log-file.txt',
                    ],
                ],
            ],
            
            'channels' => [
                // Configure a second channel
                'channelTwo' => [
                    'handlers' => [
                        'myOtherHandler',
                    ],
                ],    
            ],
        ],
    ],
];

$app = new \Slim\App($config);

// Logger using the default keys.
$container['logger'] = new \WShafer\PSR11MonoLog\MonologFactory();

// Another logger using a different channel configuration
$container['channelTwo'] = function($c) {
    return \WShafer\PSR11MonoLog\MonologFactory::channelTwo($c);
};

// Example usage
$app->get('/example', function (Request $request, Response $response) {
    
    // Get the default channel
    
    /** @var \Monolog\Logger $defaultChannel */
    $defaultChannel = $this->get('logger');
    
    // Write to the default channel
    $defaultChannel->debug('Write to log');
    
    
    // Get the second channel
    
    /** @var \Monolog\Logger $channelTwo */
    $channelTwo = $this->get('logger');
    
    // Write to the second channel
    $channelTwo->debug('Write to log');
});

$app->run();
```


# Configuration

Monolog uses four types of services that will each need to be configured for your application.
In addition you will need to create a named service that maps to the `\WShafer\PSR11MonoLog\MonologFactory`
based on the container you are using.

- Named Services : These are services names wired up to a factory.  The configuration will differ
  based on the type of container / framework in use.

- [Channels](#channels) : Channels are a great way to identify to which part of the application a record 
  is related. This is useful in big applications and is leveraged here.
  
  Picture two loggers sharing a handler that writes to a single log file. Channels allow you to 
  identify the logger that issued every record. You can easily grep through the log files filtering 
  this or that channel.

- [Handlers](#handlers) : These services do all the heavy lifting and log your message to
  the wired up system.  There are many different handlers available to you, but he one
  you will most likely want to use for basic file logging is the [StreamHandler](#streamhandler).
  _Tip: You can use the same handler for multiple channels._

- [Formatters](#formatters) : (Optional) Formatters are in charge of formatting the message
  for the handler.   Generally you can use the defualt formatter for the handler you are using, in
  some circumstances you may however want to change the formatting of the message.  Configuring
  a formatter will let you customize the message being sent to the log.

- [Processors](#processors) :  (Optional) Processors can be used to add data, change the message, filter, 
  you name it.  Monolog provides some built-in processors that can be used in your project. Look at the 
  [Processors](#processors) section for the list.

## Minimal Configuration
A minimal configuration would consist of at least one default handler and one named service.
Please note that if you don't specify a default handler a [NullHandler](#nullhandler) will be used
when you wire up the default logger.

### Minimal Example (using Zend Expressive for the example):

```php
<?php

return [
    'dependencies' => [
        'factories' => [
            // Logger using the default keys.
            'logger' => \WShafer\PSR11MonoLog\MonologFactory::class,
        ]
    ],
    
    'monolog' => [
        'handlers' => [
            'default' => [
                'type' => 'stream',
                'options' => [
                    'stream' => '/var/log/some-log-file.txt',
                ],
            ],
        ],
    ],
];
```

## Full Configuration

### Full Example
```php
<?php

return [
    
    'dependencies' => [
        'factories' => [
            // Logger using the default keys.
            'logger' => \WShafer\PSR11MonoLog\MonologFactory::class,
            
            // Another logger using a different channel configuration
            'channelTwo' => [\WShafer\PSR11MonoLog\MonologFactory::class, 'channelTwo']
        ]
    ],
        
    'monolog' => [
        'formatters' => [
            // Array Keys are the names used for the formatters
            'formatterOne' => [
                // A formatter type or pre-configured service from the container
                'type' => 'line',
                
                // Formatter specific options.  See formatters below
                'options' => [
                    'format'                     => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
                    'dateFormat'                 => "c",
                    'allowInlineLineBreaks'      => true,
                    'ignoreEmptyContextAndExtra' => false,
                ],
            ],
            
            'formatterTwo' => [
                // A formatter type or pre-configured service from the container
                'type' => 'line',
                
                // Formatter specific options.  See formatters below
                'options' => [
                    'format'                     => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
                    'dateFormat'                 => "c",
                    'allowInlineLineBreaks'      => false,
                    'ignoreEmptyContextAndExtra' => true,
                ],
            ],
        ],
        
        'handlers' => [
            // Array Keys are the names used for the handlers
            'default' => [
                // A Handler type or pre-configured service from the container
                'type' => 'stream',
                
                // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'formatter' => 'formatterOne', 
                
                // Handler specific options.  See handlers below
                'options' => [
                    'stream' => '/tmp/log_one.txt',
                ], 
            ],
            
            'handlerTwo' => [
                // A Handler type or pre-configured service from the container
                'type' => 'stream', 
                
                // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'formatter' => 'formatterTwo', 
                
                // Adaptor specific options.  See adaptors below
                'options' => [
                    'stream' => '/tmp/log_two.txt',
                ], 
            ],
        ],
        
        'processors' => [
            // Array Keys are the names used for the processors
            'processorOne' => [
                // A processor type or pre-configured service from the container
                'type' => 'psrLogMessage',
                
                // processor specific options.  See processors below
                'options' => [], 
            ],
            
            'processorTwo' => [
                // A processor type or pre-configured service from the container
                'type' => 'uid',
                
                // processor specific options.  See processors below
                'options' => [
                    'length'  => 7,
                ], 
            ],
        ],
        
        'channels' => [
            // Array Keys are the names used for the channels
            //
            // Note: You can specify "default" here to overwrite the default settings for the
            // default channel.  If no handler is defined for default then the default 
            // handler will be used.
            'default' => [
                // array of handlers to attach to the channel.  Can use multiple handlers if needed.
                'handlers' => ['handlerOne', 'handlerTwo'],
                
                // optional array of processors to attach to the channel.  Can use multiple processors if needed.
                'processors' => ['processorOne', 'processorTwo'],
            ],
            
            'channelTwo' => [
                // array of handlers to attach to the channel.  Can use multiple handlers if needed.
                'handlers' => ['handlerTwo'],
                
                // optional array of processors to attach to the channel.  Can use multiple processors if needed.
                'processors' => ['processorTwo'],
            ],
        ],
    ],
];
```

## Channels
```php
<?php

return [
    'monolog' => [
        'channels' => [
            
            // Array Keys are the channel identifiers
            'myChannelName' => [
                // Array of configured handlers.  See handlers for more info
                'handlers' => [  
                    'myHandler',  
                ],
                
                // Array of configured processors.  See processors for more info
                'processors' => [  
                    'myProcessor',  
                ],
            ],
        ],
    ],
];
```

## Handlers

### Log to files and syslog

#### StreamHandler
Logs records into any PHP stream, use this for log files.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'stream',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'stream'         => '/tmp/stream_test.txt', // Required:  File Path | Resource | Service Name
                    'level'          => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'         => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'filePermission' => null, // Optional: file permissions (default (0644) are only for owner read/write)
                    'useLocking'     => false, // Optional: Try to lock log file before doing any writes
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [StreamHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/StreamHandler.php)

#### RotatingFileHandler
Logs records to a file and creates one logfile per day. It will also delete files older than $maxFiles. 
You should use [logrotate](http://linuxcommand.org/man_pages/logrotate8.html) for high profile setups though, 
this is just meant as a quick and dirty solution.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'rotating',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'filename'       => '/tmp/stream_test.txt', // Required:  File Path
                    'maxFiles'       => 0, // Optional:  The maximal amount of files to keep (0 means unlimited)
                    'level'          => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'         => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'filePermission' => null, // Optional: file permissions (default (0644) are only for owner read/write)
                    'useLocking'     => false, // Optional: Try to lock log file before doing any writes
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [RotatingFileHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/RotatingFileHandler.php)

#### SyslogHandler
Logs records to the syslog.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'syslog',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'ident'          => '/tmp/stream_test.txt', // Required:  The string ident is added to each message. 
                    'facility'       => LOG_USER, // Optional:  The facility argument is used to specify what type of program is logging the message.
                    'level'          => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'         => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'logOpts'        => LOG_PID, // Optional: Option flags for the openlog() call, defaults to LOG_PID
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [SyslogHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/SyslogHandler.php)
PHP openlog(): [openlog](http://php.net/manual/en/function.openlog.php)

#### ErrorLogHandler
Logs records to PHP's [error_log()](http://docs.php.net/manual/en/function.error-log.php) function.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'errorlog',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'messageType'    => \Monolog\Handler\ErrorLogHandler::OPERATING_SYSTEM, // Optional:  Says where the error should go.
                    'level'          => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'         => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'expandNewlines' => false, // Optional: If set to true, newlines in the message will be expanded to be take multiple log entries
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [ErrorLogHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/ErrorLogHandler.php)

### Send alerts and emails

#### NativeMailerHandler
Sends emails using PHP's [mail()](http://php.net/manual/en/function.mail.php) function.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'nativeMailer',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'to'             => ['email1@test.com', 'email2@test.com'], // The receiver of the mail. Can be an array or string
                    'subject'        => 'Error Log', // The subject of the mail
                    'from'           => 'sender@test.com', // The sender of the mail
                    'level'          => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'         => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'maxColumnWidth' => 80, // Optional: The maximum column width that the message lines will have
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [NativeMailerHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/NativeMailerHandler.php)

#### SwiftMailerHandler
Sends emails using a [Swift_Mailer](http://swiftmailer.org/) instance.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'swiftMailer',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'mailer'  => 'my-service', // The mailer to use.  Must be a valid service name in the container
                    'message' => 'my-message', // An example message for real messages, only the body will be replaced.  Must be a valid service name or callable
                    'level'   => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'  => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [SwiftMailerHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/SwiftMailerHandler.php)

#### PushoverHandler
Sends mobile notifications via the [Pushover](https://www.pushover.net/) API.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'pushover',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'token'             => 'sometokenhere', // Pushover api token
                    'users'             => ['email1@test.com', 'email2@test.com'], // Pushover user id or array of ids the message will be sent to
                    'title'             => 'Error Log', // Optional: Title sent to the Pushover API
                    'level'             => \Monolog\Logger::INFO, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'            => false, // Optional:  Whether the messages that are handled can bubble up the stack or not
                    'useSSL'            => false, // Optional:  Whether to connect via SSL. Required when pushing messages to users that are not the pushover.net app owner. OpenSSL is required for this option.
                    'highPriorityLevel' => \Monolog\Logger::WARNING, // Optional: The minimum logging level at which this handler will start sending "high priority" requests to the Pushover API
                    'emergencyLevel'    => \Monolog\Logger::ERROR, // Optional: The minimum logging level at which this handler will start sending "emergency" requests to the Pushover API
                    'retry'             => '22', // Optional: The retry parameter specifies how often (in seconds) the Pushover servers will send the same notification to the user.
                    'expire'            => '300', // Optional: The expire parameter specifies how many seconds your notification will continue to be retried for (every retry seconds).
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [PushoverHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/PushoverHandler.php)

#### HipChatHandler
Sends notifications through the [HipChat](http://hipchat.com/) api to a hipchat room

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'hipChat',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'token'  => 'sometokenhere', // HipChat API Token
                    'room'   => 'some-room', // The room that should be alerted of the message (Id or Name)
                    'name'   => 'Error Log', // Optional: Name used in the "from" field.
                    'notify' => false, // Optional: Trigger a notification in clients or not
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'useSSL' => false, // Optional: Whether to connect via SSL
                    'format' => 'text', // Optional: The format of the messages (default to text, can be set to html if you have html in the messages)
                    'host'   => 'api.hipchat.com', // Optional: The HipChat server hostname.
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [HipChatHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/HipChatHandler.php)

#### FlowdockHandler
Logs records to a [Flowdock](https://www.flowdock.com/) account.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'flowdock',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'apiToken' => 'sometokenhere', // HipChat API Token
                    'level'    => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'   => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [FlowdockHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/FlowdockHandler.php)


#### SlackbotHandler
Logs records to a [Slack](https://www.slack.com/) account using the Slackbot incoming hook.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'slackbot',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'slackTeam' => 'Team', // Slackbot token
                    'token'     => 'sometokenhere', // HipChat API Token
                    'channel'   => '#channel', // Slack channel (encoded ID or name)
                    'level'     => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'    => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [SlackbotHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/SlackbotHandler.php)

#### SlackWebhookHandler
Logs records to a [Slack](https://www.slack.com/) account using Slack Webhooks.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'slackWebhook',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'webhookUrl'             => 'webhook.slack.com', // Slack Webhook URL
                    'channel'                => 'channel', // Slack channel (encoded ID or name)
                    'userName'               => 'Monolog', // Name of a bot
                    'useAttachment'          => false, // Optional: Whether the message should be added to Slack as attachment (plain text otherwise)
                    'iconEmoji'              => null, // Optional: The emoji name to use (or null)
                    'useShortAttachment'     => true, // Optional: Whether the the context/extra messages added to Slack as attachments are in a short style
                    'includeContextAndExtra' => true, // Optional: Whether the attachment should include context and extra data
                    'level'                  => \Monolog\Logger::INFO, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'                 => false, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'excludeFields'          => ['context.field1', 'extra.field2'], // Optional: Dot separated list of fields to exclude from slack message.
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [SlackWebhookHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/SlackWebhookHandler.php)

#### SlackHandler
Logs records to a [SlackHandler](https://www.slack.com/) account using the Slack API (complex setup).

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'slack',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'token     '             => 'apiToken', // Slack API token
                    'channel'                => 'channel', // Slack channel (encoded ID or name)
                    'userName'               => 'Monolog', // Name of a bot
                    'useAttachment'          => false, // Optional: Whether the message should be added to Slack as attachment (plain text otherwise)
                    'iconEmoji'              => null, // Optional: The emoji name to use (or null)
                    'useShortAttachment'     => true, // Optional: Whether the the context/extra messages added to Slack as attachments are in a short style
                    'includeContextAndExtra' => true, // Optional: Whether the attachment should include context and extra data
                    'level'                  => \Monolog\Logger::INFO, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'                 => false, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'excludeFields'          => ['context.field1', 'extra.field2'], // Optional: Dot separated list of fields to exclude from slack message.
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [SlackHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/SlackHandler.php)

#### MandrillHandler
Sends emails via the [Mandrill](http://www.mandrill.com/) API using a [Swift_Message](http://swiftmailer.org/) instance.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'mandrill',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'apiKey'  => 'my-service', // A valid Mandrill API key
                    'message' => 'my-message', // An example \Swiftmail message for real messages, only the body will be replaced.  Must be a valid service name or callable
                    'level'   => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'  => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [MandrillHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/MandrillHandler.php)

#### FleepHookHandler
Logs records to a [Fleep](https://fleep.io/) conversation using Webhooks.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'fleepHook',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'token'  => 'sometokenhere', // Webhook token
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [FleepHookHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/FleepHookHandler.php)

#### IFTTTHandler
Notifies an [IFTTT](https://ifttt.com/maker) trigger with the log channel, level name and message.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'IFTTT',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'apiToken' => 'sometokenhere', // Webhook token
                    'level'    => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'   => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [IFTTTHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/IFTTTHandler.php)

### Log specific servers and networked logging

#### SocketHandler
Logs records to [sockets](http://php.net/fsockopen), use this for UNIX and TCP sockets. See an [example](https://github.com/Seldaek/monolog/blob/master/doc/sockets.md).

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'socket',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'connectionString' => 'unix:///var/log/httpd_app_log.socket', // Socket connection string.  You can use a unix:// prefix to access unix sockets and udp:// to open UDP sockets instead of the default TCP.
                    'timeout'          => 30, // Optional: The connection timeout, in seconds.
                    'writeTimeout'     => 90, // Optional: Set timeout period on a stream.
                    'level'            => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'           => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [SocketHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/SocketHandler.php)

#### AmqpHandler
Logs records to an [AMQP](http://www.amqp.org/) compatible server. Requires the [php-amqp](http://pecl.php.net/package/amqp) extension (1.0+) or the [php-amqplib](https://github.com/php-amqplib/php-amqplib) library.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'amqp',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'exchange'     => 'my-service', // AMQPExchange (php AMQP ext) or PHP AMQP lib channel.  Must be a valid service.
                    'exchangeName' => 'log-name', // Optional: Exchange name, for AMQPChannel (PhpAmqpLib) only
                    'level'        => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'       => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [AmqpHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/AmqpHandler.php)

#### GelfHandler
Logs records to a [Graylog2](http://www.graylog2.org) server. Requires package [graylog2/gelf-php](https://github.com/bzikarsky/gelf-php).
```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'gelf',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'publisher' => 'my-service', // A Gelf\PublisherInterface object.  Must be a valid service.
                    'level'     => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'    => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [GelfHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/GelfHandler.php)

#### CubeHandler
Logs records to a [Cube](http://square.github.com/cube/) server.

_Note: Cube is not under active development, maintenance or support by 
Square (or by its original author Mike Bostock). It has been deprecated 
internally for over a year._

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'cube',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'url'    => 'http://test.com:80', // A valid url.  Must consist of three parts : protocol://host:port
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [CubeHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/CubeHandler.php)

#### RavenHandler
Logs records to a [Sentry](http://getsentry.com/) server using [raven](https://packagist.org/packages/raven/raven).
```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'raven',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'client' => 'my-service', // A \Raven_Client object.  Must be a valid service.
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [RavenHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/RavenHandler.php)

#### ZendMonitorHandler
Logs records to the Zend Monitor present in [Zend Server](http://www.zend.com/en/products/zend_server).
```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'zend',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [ZendMonitorHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/ZendMonitorHandler.php)

#### NewRelicHandler
Logs records to a [NewRelic](http://newrelic.com/) application.
```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'newRelic',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'level'           => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'          => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'appName'         => 'my-app', // Optional: Application name
                    'explodeArrays'   => 'false', // Optional: Explode Arrays
                    'transactionName' => 'my-transaction', // Optional: Explode Arrays
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [NewRelicHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/NewRelicHandler.php)

#### LogglyHandler
Logs records to a [Loggly](http://www.loggly.com/) account.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'loggly',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'token'  => 'sometokenhere', // Webhook token
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [LogglyHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/LogglyHandler.php)

#### RollbarHandler:
Logs records to a [Rollbar](https://rollbar.com/) account.

_Note: RollerbarHandler is out of date with upstream changes. In addition the Rollerbar library suggests using 
the PsrHandler instead.  See [Rollerbar Docs](https://github.com/rollbar/rollbar-php#using-monolog) for how to set this up.

Monolog Docs: [RollbarHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/RollbarHandler.php)

#### SyslogUdpHandler
Logs records to a remote [Syslogd](http://www.rsyslog.com/) server.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'syslogUdp',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'host'     => 'somewhere.com', // Host
                    'port'     => 513, //  Optional: Port
                    'facility' => 'Me', // Optional: Facility
                    'level'    => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'   => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'ident'    => 'me-too', // Optional: Program name or tag for each log message.
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [SyslogUdpHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/SyslogUdpHandler.php)

#### LogEntriesHandler
Logs records to a [LogEntries](http://logentries.com/) account.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'logEntries',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'token'  => 'sometokenhere', // Log token supplied by LogEntries
                    'useSSL' => true, // Optional: Whether or not SSL encryption should be used.
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [LogEntriesHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/LogEntriesHandler.php)

### Logging in development

##### FirePHPHandler
Handler for [FirePHP](http://www.firephp.org/), providing inline console messages within [FireBug](http://getfirebug.com/).

_Note: The Firebug extension isn't being developed or maintained any longer._

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'firePHP',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [FirePHPHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/LogEntriesHandler.php)

#### ChromePHPHandler
Handler for [ChromePHP](http://www.chromephp.com/), providing inline console messages within Chrome.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'chromePHP',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [ChromePHPHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/ChromePHPHandler.php)

#### BrowserConsoleHandler
Handler to send logs to browser's Javascript console with no browser extension required. Most browsers supporting 
console API are supported.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'browserConsole',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [BrowserConsoleHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/BrowserConsoleHandler.php)

#### PHPConsoleHandler
Handler for [PHP Console](https://chrome.google.com/webstore/detail/php-console/nfhmhhlpfleoednkpnnnkolmclajemef), 
providing inline console and notification popup messages within Chrome.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'phpConsole',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'options' => [], // Optional: See \Monolog\Handler\PHPConsoleHandler::$options for more details
                    'connector' => 'my-service', // Optional:  Instance of \PhpConsole\Connector class. Must be a valid service.
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [PHPConsoleHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/PHPConsoleHandler.php)


###Logging in development

#### RedisHandler
Logs records to a [Redis](http://redis.io/) server.   Requires the [php-redis](https://pecl.php.net/package/redis) 
extension or the [Predis](https://github.com/nrk/predis) library.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'redis',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'client'  => 'my-redis-service-name', // The redis instance.  Must be either a [Predis] client OR a Pecl Redis instance
                    'key'     => 'my-service', // The key name to push records to
                    'level'   => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'  => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'capSize' => true, // Optional: Number of entries to limit list size to, 0 = unlimited
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [RedisHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/RedisHandler.php)

#### MongoDBHandler
Handler to write records in MongoDB via a [Mongo extension](http://php.net/manual/en/mongodb.tutorial.library.php) connection.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'mongo',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'client'     => 'my-mongo-service-name', // MongoDB library or driver instance.
                    'database'   => 'my-db', // Database name
                    'collection' => 'collectionName', // Collection name
                    'level'      => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'     => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                    'capSize'    => true, // Optional: Number of entries to limit list size to, 0 = unlimited
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [MongoDBHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/MongoDBHandler.php)

#### CouchDBHandler
Logs records to a CouchDB server.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'couchDb',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'host'     => 'localhost',  // Optional: Hostname/Ip address,  Default: 'localhost'
                    'port'     => 5984, // Optional: port,  Default: 5984
                    'dbname'   => 'db', // Optional: Database Name,  Default: 'logger'
                    'username' => 'someuser', // Optional: Username,  Default: null
                    'password' => 'somepass', // Optional: Password,  Default: null
                    'level'    => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'   => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [CouchDBHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/CouchDBHandler.php)

#### DoctrineCouchDBHandler
Logs records to a CouchDB server via the Doctrine CouchDB ODM.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'doctrineCouchDb',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'client' => 'my-service', //  CouchDBClient service name.  Must be a valid container service
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [DoctrineCouchDBHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/DoctrineCouchDBHandler.php)

#### ElasticSearchHandler
Logs records to an Elastic Search server.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'doctrineCouchDb',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'client'      => 'my-service', //  Elastica Client object.  Must be a valid container service
                    'index'       => 'monolog', // Optional: Elastic index name
                    'type'        => 'record', // Optional: Elastic document type
                    'ignoreError' => false, // Optional: Suppress Elastica exceptions
                    'level'       => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'      => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [ElasticSearchHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/ElasticSearchHandler.php)

#### DynamoDbHandler
Logs records to a DynamoDB table with the [AWS SDK](https://github.com/aws/aws-sdk-php).

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'dynamoDb',
                'formatter' => 'formatterName', // Optional: Formatter for the handler.  Default for the handler will be used if not supplied
                'options' => [
                    'client'      => 'my-service', //  DynamoDbClient object.  Must be a valid container service
                    'table'       => 'monolog', // Table name
                    'level'       => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'      => true, // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [DynamoDbHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/DynamoDbHandler.php)

### Wrappers / Special Handlers

#### FingersCrossedHandler
A very interesting wrapper. It takes a logger as parameter and will accumulate log 
records of all levels until a record exceeds the defined severity level. At which 
point it delivers all records, including those of lower severity, to the handler it 
wraps. This means that until an error actually happens you will not see anything in 
your logs, but when it happens you will have the full information, including debug and 
info records. This provides you with all the information you need, but only when you 
need it.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'fingersCrossed',
                'options' => [
                    'handler'            => 'my-handler', // Required: Registered Handler to wrap
                    'activationStrategy' => 'my-service', // Optional: Strategy which determines when this handler takes action.  Must be either the error level or configured ActivationStrategyInterface service
                    'bufferSize'         => 0,            // Optional: How many entries should be buffered at most, beyond that the oldest items are removed from the buffer.
                    'bubble'             => true,         // Optional: Whether the messages that are handled can bubble up the stack or not
                    'stopBuffering'      => true,         // Optional: Whether the handler should stop buffering after being triggered (default true)
                    'passthruLevel'      => null,         // Optional: Minimum level to always flush to handler on close, even if strategy not triggered
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [FingersCrossedHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/FingersCrossedHandler.php)


#### DeduplicationHandler
Useful if you are sending notifications or emails when critical errors occur. It takes 
a logger as parameter and will accumulate log records of all levels until the end 
of the request (or flush() is called). At that point it delivers all records to 
the handler it wraps, but only if the records are unique over a given time 
period (60 seconds by default). If the records are duplicates they are simply 
discarded. The main use of this is in case of critical failure like if your database 
is unreachable for example all your requests will fail and that can result in a lot 
of notifications being sent. Adding this handler reduces the amount of notifications 
to a manageable level.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'deduplication',
                'options' => [
                    'handler'            => 'my-handler',           // Required: Registered Handler to wrap
                    'deduplicationStore' => '/tmp/somestore',       // Optional: The file/path where the deduplication log should be kept
                    'deduplicationLevel' => \Monolog\Logger::ERROR, // Optional:The minimum logging level for log records to be looked at for deduplication purposes
                    'time'               => 60,                     // Optional: The period (in seconds) during which duplicate entries should be suppressed after a given log is sent through
                    'bubble'             => true,                   // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [DeduplicationHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/DeduplicationHandler.php)

#### WhatFailureGroupHandler
This handler extends the GroupHandler ignoring exceptions raised by each child handler. 
This allows you to ignore issues where a remote tcp connection may have died but you 
do not want your entire application to crash and may wish to continue to log to other handlers.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'whatFailureGroup',
                'options' => [
                    'handlers' => ['my-handler-one'. 'my-handler-two'], // Required: Array of Registered Handlers to wrap
                    'bubble'   => true,                                 // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [WhatFailureGroupHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/WhatFailureGroupHandler.php)


#### BufferHandler
This handler will buffer all the log records it receives until close() is called at which point it 
will call handleBatch() on the handler it wraps with all the log messages at once. This is very 
useful to send an email with all records at once for example instead of having one mail for 
every log record.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'buffer',
                'options' => [
                    'handler'         => 'my-handler',           // Required: Registered Handler to wrap
                    'bufferLimit'     => 0,                      // Optional: How many entries should be buffered at most, beyond that the oldest items are removed from the buffer.
                    'level'           => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble'          => true,                   // Optional: Whether the messages that are handled can bubble up the stack or not
                    'flushOnOverflow' => false,                  // Optional: If true, the buffer is flushed when the max size has been reached, by default oldest entries are discarded
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [BufferHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/BufferHandler.php)


#### GroupHandler
This handler groups other handlers. Every record received is sent to all the handlers it is configured with.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'group',
                'options' => [
                    'handlers' => ['my-handler-one'. 'my-handler-two'], // Required: Array of Registered Handlers to wrap
                    'bubble'   => true,                                 // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [GroupHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/GroupHandler.php)


#### FilterHandler
Simple handler wrapper that filters records based on a list of levels

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'filter',
                'options' => [
                    'handler'         => 'my-handler',               // Required: Registered Handler to wrap
                    'minLevelOrList'  => \Monolog\Logger::DEBUG,     // Optional: An array of levels to accept or a minimum level if maxLevel is provided
                    'maxLevel'        => \Monolog\Logger::EMERGENCY, // Optional: Maximum level to accept, only used if $minLevelOrList is not an array
                    'bubble'          => true,                       // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [FilterHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/FilterHandler.php)


#### SamplingHandler
A sampled event stream can be useful for logging high frequency events in
a production environment where you only need an idea of what is happening
and are not concerned with capturing every occurrence. Since the decision to
handle or not handle a particular event is determined randomly, the
resulting sampled log is not guaranteed to contain 1/N of the events that
occurred in the application, but based on the Law of large numbers, it will
tend to be close to this ratio with a large number of attempts.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'sampling',
                'options' => [
                    'handler' => 'my-handler', // Required: Registered Handler to wrap
                    'factor'  => 5,            // Required: Sample factor
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [SamplingHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/SamplingHandler.php)


#### NullHandler
Any record it can handle will be thrown away. This can be used
to put on top of an existing stack to override it temporarily.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type'    => 'noop',
                'options' => [
                    'level' => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [NullHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/NullHandler.php)


#### PsrHandler
Can be used to forward log records to an existing PSR-3 logger

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type'    => 'psr',
                'options' => [
                    'logger' => 'loggerService',        // Required: Logger Service to wrap from the container
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true,                   // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [PsrHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/PsrHandler.php)


#### TestHandler
Used for testing, it records everything that is sent to it and has accessors to read out the information.

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type'    => 'test',
                'options' => [
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this handler will be triggered
                    'bubble' => true,                   // Optional: Whether the messages that are handled can bubble up the stack or not
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [TestHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/TestHandler.php)


## Formatters

### LineFomatter
Formats a log record into a one-line string.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'line',
                'options' => [
                    'format'                     => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",  // Optional
                    'dateFormat'                 => "c", // Optional : The format of the timestamp: one supported by DateTime::format
                    'allowInlineLineBreaks'      => false, // Optional : Whether to allow inline line breaks in log entries
                    'ignoreEmptyContextAndExtra' => false, // Optional
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [LineFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/LineFormatter.php)

### HtmlFormatter
Used to format log records into a human readable html table, mainly suitable for emails.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'html',
                'options' => [
                    'dateFormat' => "c", // Optional
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [HtmlFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/HtmlFormatter.php)

### NormalizerFormatter
Normalizes objects/resources down to strings so a record can easily be serialized/encoded.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'normalizer',
                'options' => [
                    'dateFormat' => "c", // Optional
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [NormalizerFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/NormalizerFormatter.php)

### ScalarFormatter
Used to format log records into an associative array of scalar values.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'scalar',
                'options' => [], // No options available
            ],
        ],
    ],
];
```
Monolog Docs: [ScalarFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/ScalarFormatter.php)

### JsonFormatter
Encodes a log record into json.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'json',
                'options' => [
                    'batchMode'     => \Monolog\Formatter\JsonFormatter::BATCH_MODE_JSON, //optional
                    'appendNewline' => true, //optional
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [JsonFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/JsonFormatter.php)

### WildfireFormatter
Used to format log records into the Wildfire/FirePHP protocol, only useful for the FirePHPHandler.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'wildfire',
                'options' => [
                    'dateFormat' => "c", // Optional
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [WildfireFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/WildfireFormatter.php)

### ChromePHPFormatter
Used to format log records into the ChromePHP format, only useful for the ChromePHPHandler.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'chromePHP',
                'options' => [], // No options available
            ],
        ],
    ],
];
```
Monolog Docs: [ChromePHPFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/ScalarFormatter.php)

### GelfMessageFormatter
Used to format log records into Gelf message instances, only useful for the GelfHandler.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'gelf',
                'options' => [
                    'systemName'    => "my-system",  // Optional : the name of the system for the Gelf log message, defaults to the hostname of the machine
                    'extraPrefix'   => "extra_", // Optional : a prefix for 'extra' fields from the Monolog record
                    'contextPrefix' => 'ctxt_', // Optional : a prefix for 'context' fields from the Monolog record
                    'maxLength'     => 32766, // Optional : Length per field
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [GelfMessageFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/GelfMessageFormatter.php)

### LogstashFormatter
Used to format log records into logstash event json, useful for any handler listed under inputs here.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'logstash',
                'options' => [
                    'applicationName' => 'app-name', // the application that sends the data, used as the "type" field of logstash
                    'systemName'      => "my-system",  // Optional : the system/machine name, used as the "source" field of logstash, defaults to the hostname of the machine
                    'extraPrefix'     => "extra_", // Optional : prefix for extra keys inside logstash "fields"
                    'contextPrefix'   => 'ctxt_', // Optional : prefix for context keys inside logstash "fields", defaults to ctxt_
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [LogstashFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/LogstashFormatter.php)


### ElasticaFormatter
Used to format log records into [logstash](http://logstash.net/) event json, useful for any handler listed 
under inputs [here](http://logstash.net/docs/latest).

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'ElasticaFormatter' => [
                'type' => 'elastica',
                'options' => [
                    'index'   => 'some-index', // Elastic search index name
                    'type'    => "doc-type",  // Elastic search document type
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [ElasticaFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/ElasticaFormatter.php)

### LogglyFormatter
Used to format log records into Loggly messages, only useful for the LogglyHandler.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'loggly',
                'options' => [
                    'batchMode'     => \Monolog\Formatter\JsonFormatter::BATCH_MODE_NEWLINES, //optional
                    'appendNewline' => false, //optional
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [LogglyFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/LogglyFormatter.php)

### FlowdockFormatter
Used to format log records into Flowdock messages, only useful for the FlowdockHandler.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'flowdock',
                'options' => [
                    'source'      => 'Some Source',
                    'sourceEmail' => 'source@email.com'
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [FlowdockFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/FlowdockFormatter.php)

### MongoDBFormatter
Converts \DateTime instances to \MongoDate and objects recursively to arrays, only useful with the MongoDBHandler.

```php
<?php

return [
    'monolog' => [
        'formatters' => [
            'myFormatterName' => [
                'type' => 'mongodb',
                'options' => [
                    'maxNestingLevel'        => 3, // optional : 0 means infinite nesting, the $record itself is level 1, $record['context'] is 2
                    'exceptionTraceAsString' => true, // optional : set to false to log exception traces as a sub documents instead of strings
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [MongoDBFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/MongoDBFormatter.php)

## Processors

### PsrLogMessageProcessor
Processes a log record's message according to PSR-3 rules, replacing {foo} with the value from $context['foo'].

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'psrLogMessage',
                'options' => [], // No options
            ],
        ],
    ],
];
```
Monolog Docs: [PsrLogMessageProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/PsrLogMessageProcessor.php)

### IntrospectionProcessor
Adds the line/file/class/method from which the log call originated.

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'introspection',
                'options' => [
                    'level'                => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this processor will be triggered
                    'skipClassesPartials'  => [], // Optional
                    'skipStackFramesCount' => 0, // Optional
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [IntrospectionProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/IntrospectionProcessor.php)

### WebProcessor
Adds the current request URI, request method and client IP to a log record.

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'web',
                'options' => [
                    'serverData'  => 'my-service', // Optional: Array, object w/ ArrayAccess, or valid service name that provides access to the $_SERVER data
                    'extraFields' => [], // Optional: Field names and the related key inside $serverData to be added. If not provided it defaults to: url, ip, http_method, server, referrer
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [WebProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/WebProcessor.php)

### MemoryUsageProcessor
Adds the current memory usage to a log record.

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'memoryUsage',
                'options' => [], // No options
            ],
        ],
    ],
];
```
Monolog Docs: [MemoryUsageProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/MemoryUsageProcessor.php)

### MemoryPeakUsageProcessor
Adds the peak memory usage to a log record.

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'memoryPeak',
                'options' => [], // No options
            ],
        ],
    ],
];
```
Monolog Docs: [MemoryPeakUsageProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/MemoryPeakUsageProcessor.php)

### ProcessIdProcessor
Adds the process id to a log record.

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'processId',
                'options' => [], // No options
            ],
        ],
    ],
];
```
Monolog Docs: [ProcessIdProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/ProcessIdProcessor.php)

### UidProcessor
Adds a unique identifier to a log record.

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'uid',
                'options' => [
                    'length'  => 7, // Optional: The uid length. Must be an integer between 1 and 32
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [UidProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/UidProcessor.php)

### GitProcessor
Adds the current git branch and commit to a log record.

_Note:  Only works if the git executable is in your working path._

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'git',
                'options' => [
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this processor will be triggered
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [GitProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/GitProcessor.php)

### MercurialProcessor
Adds the current hg branch and commit to a log record.

_Note:  Only works if the hg executable is in your working path._

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'mercurial',
                'options' => [
                    'level'  => \Monolog\Logger::DEBUG, // Optional: The minimum logging level at which this processor will be triggered
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [MercurialProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/MercurialProcessor.php)

### TagProcessor
Adds an array of predefined tags to a log record.

```php
<?php

return [
    'monolog' => [
        'processors' => [
            'myProcessorsName' => [
                'type' => 'tags',
                'options' => [
                    'tags'  => [], // Optional: Array of tags to add to records
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [TagProcessor](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Processor/TagProcessor.php)


### Upgrades

#### Version 1 to Version 2
When upgrading from version 1 to version 2, there shouldn't be any changes needed.   Please note
that using the ChannelChanger directly is no longer recommended.  Named services
should be used instead.  See above for more info.

##### Changes
* A "default" channel entry and handler is added automatically to the config.  This default
channel requires you to either specify a configured handler for the channel
OR there must be a 'default' channel configured in order to use it.  Most Version 1
users should not have an issue with this change and the factories should still function
normally.
