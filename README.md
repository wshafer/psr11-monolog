[![codecov](https://codecov.io/gh/wshafer/psr11-monolog/branch/master/graph/badge.svg)](https://codecov.io/gh/wshafer/psr11-monolog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wshafer/psr11-monolog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wshafer/psr11-monolog/?branch=master)
[![Build Status](https://travis-ci.org/wshafer/psr11-monolog.svg?branch=master)](https://travis-ci.org/wshafer/psr11-monolog)
# PSR-11 Monolog

[Monolog](https://github.com/Seldaek/monolog) Factories for PSR-11

#### Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
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
    

# Installation

```bash
composer require wshafer/psr11-monolog
```

# Configuration

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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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

_Note: RollerbarHandler is out of date with upstream changes.  We can not support this factory until this handler is fixed.
Upstream ticket: https://github.com/Seldaek/monolog/issues/1021_

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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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

#### FirePHPHandler
Handler for [FirePHP](http://www.firephp.org/), providing inline console messages within [FireBug](http://getfirebug.com/).

_Note: The Firebug extension isn't being developed or maintained any longer._

```php
<?php

return [
    'monolog' => [
        'handlers' => [
            'myHandlerName' => [
                'type' => 'firePHP',
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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
                'formatters' => ['formatterName'], // Optional: Formatters for the handler.  Default for the handler will be used if not supplied
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


## Formatters

#### LineFomatter
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


#### HtmlFormatter
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

#### NormalizerFormatter
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

#### ScalarFormatter
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

#### JsonFormatter
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

#### WildfireFormatter
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

#### ChromePHPFormatter
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

#### GelfMessageFormatter
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
                ],
            ],
        ],
    ],
];
```
Monolog Docs: [GelfMessageFormatter](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Formatter/GelfMessageFormatter.php)

#### LogstashFormatter
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


#### ElasticaFormatter
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

#### LogglyFormatter
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

#### FlowdockFormatter
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

#### MongoDBFormatter
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
