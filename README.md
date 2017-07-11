[![codecov](https://codecov.io/gh/wshafer/psr11-monolog/branch/master/graph/badge.svg)](https://codecov.io/gh/wshafer/psr11-monolog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wshafer/psr11-monolog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wshafer/psr11-monolog/?branch=master)
[![Build Status](https://travis-ci.org/wshafer/psr11-monolog.svg?branch=master)](https://travis-ci.org/wshafer/psr11-monolog)
# PSR-11 Monolog

[Monolog](https://github.com/Seldaek/monolog) Factories for PSR-11

#### Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
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
    - [Handlers](#handlers)
        - [StreamHandler](#streamhandler)
        - [RotatingFileHandler](#rotatingfilehandler)
        - [SyslogHandler](#sysloghandler)
        - [ErrorLogHandler](#errorloghandler)
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
    

# Installation

```bash
composer require wshafer/psr11-monolog
```

# Configuration


### Formatters

#### LineFomatter
Formats a log record into a one-line string.

```php
<?php

return [
    'monolog' => [
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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
        'formatter' => [
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

### Handlers

#### StreamHandler
Logs records into any PHP stream, use this for log files.

```php
<?php

return [
    'monolog' => [
        'handler' => [
            'myHandlerName' => [
                'type' => 'stream',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'rotating',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'syslog',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'errorlog',
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

#### NativeMailerHandler
Sends emails using PHP's [mail()](http://php.net/manual/en/function.mail.php) function.

```php
<?php

return [
    'monolog' => [
        'handler' => [
            'myHandlerName' => [
                'type' => 'nativeMailer',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'swiftMailer',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'pushover',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'hipChat',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'flowdock',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'slackbot',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'slackWebhook',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'slack',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'mandrill',
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
        'handler' => [
            'myHandlerName' => [
                'type' => 'fleepHook',
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
Monolog Docs: [FleepHookHandler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/FleepHookHandler.php)

#### IFTTTHandler
Notifies an [IFTTT](https://ifttt.com/maker) trigger with the log channel, level name and message.

```php
<?php

return [
    'monolog' => [
        'handler' => [
            'myHandlerName' => [
                'type' => 'fleepHook',
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
