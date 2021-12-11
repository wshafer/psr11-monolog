<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use Antidot\Async\Logger\EchoHandler;
use WShafer\PSR11MonoLog\MapperInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class HandlerMapper implements MapperInterface
{
    public function map(string $type)
    {
        $type = strtolower($type);

        switch ($type) {
            case 'echo':
                return EchoHandlerFactory::class;
            case 'stream':
                return StreamHandlerFactory::class;
            case 'react_filesystem':
                return ReactFilesystemHandlerFactory::class;
            case 'rotating':
                return RotatingFileHandlerFactory::class;
            case 'syslog':
                return SyslogHandlerFactory::class;
            case 'errorlog':
                return ErrorLogHandlerFactory::class;
            case 'nativemailer':
                return NativeMailerHandlerFactory::class;
            case 'swiftmailer':
                return SwiftMailerHandlerFactory::class;
            case 'pushover':
                return PushoverHandlerFactory::class;
            case 'flowdock':
                return FlowdockHandlerFactory::class;
            case 'slackwebhook':
                return SlackWebhookHandlerFactory::class;
            case 'slack':
                return SlackHandlerFactory::class;
            case 'mandrill':
                return MandrillHandlerFactory::class;
            case 'fleephook':
                return FleepHookHandlerFactory::class;
            case 'ifttt':
                return IFTTTHandlerFactory::class;
            case 'socket':
                return SocketHandlerFactory::class;
            case 'amqp':
                return AmqpHandlerFactory::class;
            case 'gelf':
                return GelfHandlerFactory::class;
            case 'cube':
                return CubeHandlerFactory::class;
            case 'zend':
                return ZendMonitorHandlerFactory::class;
            case 'newrelic':
                return NewRelicHandlerFactory::class;
            case 'loggly':
                return LogglyHandlerFactory::class;
            case 'syslogudp':
                return SyslogUdpHandlerFactory::class;
            case 'logentries':
                return LogEntriesHandlerFactory::class;
            case 'firephp':
                return FirePHPHandlerFactory::class;
            case 'chromephp':
                return ChromePHPHandlerFactory::class;
            case 'browserconsole':
                return BrowserConsoleHandlerFactory::class;
            case 'phpconsole':
                return PHPConsoleHandlerFactory::class;
            case 'redis':
                return RedisHandlerFactory::class;
            case 'mongo':
                return MongoDBHandlerFactory::class;
            case 'couchdb':
                return CouchDBHandlerFactory::class;
            case 'doctrinecouchdb':
                return DoctrineCouchDBHandlerFactory::class;
            case 'elastica':
                return ElasticaHandlerFactory::class;
            case 'dynamodb':
                return DynamoDbHandlerFactory::class;
            case 'fingerscrossed':
                return FingersCrossedHandlerFactory::class;
            case 'deduplication':
                return DeduplicationHandlerFactory::class;
            case 'whatfailuregrouphandler':
                return WhatFailureGroupHandlerFactory::class;
            case 'buffer':
                return BufferHandlerFactory::class;
            case 'group':
                return GroupHandlerFactory::class;
            case 'filter':
                return FilterHandlerFactory::class;
            case 'sampling':
                return SamplingHandlerFactory::class;
            case 'null':
                return NullHandlerFactory::class;
            case 'psr':
                return PsrHandlerFactory::class;
            case 'process':
                return ProcessHandlerFactory::class;
            case 'sendgrid':
                return SendGridHandlerFactory::class;
            case 'telegrambot':
                return TelegramBotHandlerFactory::class;
            case 'insightops':
                return InsightOpsHandlerFactory::class;
            case 'logmatic':
                return LogmaticHandlerFactory::class;
            case 'sqs':
                return SqsHandlerFactory::class;
            case 'fallbackgroup':
                return FallbackGroupHandlerFactory::class;
            case 'noop':
                return NoopHandlerFactory::class;
            case 'overflow':
                return OverflowHandlerFactory::class;
            case 'test':
                return TestHandlerFactory::class;
        }

        return null;
    }
}
