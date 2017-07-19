<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Handler;

use WShafer\PSR11MonoLog\MapperInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class HandlerMapper implements MapperInterface
{
    /**
     * @param string $type
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function map(string $type)
    {
        $type = strtolower($type);

        switch ($type) {
            case 'stream':
                return StreamHandlerFactory::class;
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
            case 'hipchat':
                return HipChatHandlerFactory::class;
            case 'flowdock':
                return FlowdockHandlerFactory::class;
            case 'slackbot':
                return SlackbotHandlerFactory::class;
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
            case 'raven':
                return RavenHandlerFactory::class;
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
            case 'elasticsearch':
                return ElasticSearchHandlerFactory::class;
        }

        return null;
    }
}
