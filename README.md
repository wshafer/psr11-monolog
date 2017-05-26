[![codecov](https://codecov.io/gh/wshafer/psr11-monolog/branch/master/graph/badge.svg)](https://codecov.io/gh/wshafer/psr11-monolog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wshafer/psr11-monolog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wshafer/psr11-monolog/?branch=master)
[![Build Status](https://travis-ci.org/wshafer/psr11-monolog.svg?branch=master)](https://travis-ci.org/wshafer/psr11-monolog)
# PSR-11 Monolog

[Monolog](https://github.com/Seldaek/monolog) Factories for PSR-11

#### Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
    - [Formatters](#formatters)
        - [LineFomatter](#line-fomatter)
        - [HtmlFormatter](#html-formatter)
        - [NormalizerFormatter](#normalizer-formatter)
        - [ScalarFormatter](#scalar-formatter)
        - [JsonFormatter](#json-formatter)
        - [WildfireFormatter](#wildfire-formatter)
        - [ChromePHPFormatter](#chrome-p-h-p-formatter)
        - [GelfMessageFormatter](#gelf-message-formatter)
        - [LogstashFormatter](#logstash-formatter)
        - [ElasticaFormatter](#elastica-formatter)
        - [LogglyFormatter](#loggly-formatter)
        - [FlowdockFormatter](#flowdock-formatter)
        - [MongoDBFormatter](#mongo-d-b-formatter)
    

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
