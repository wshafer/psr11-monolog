<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\AmqpHandlerFactory;
use WShafer\PSR11MonoLog\Handler\BrowserConsoleHandlerFactory;
use WShafer\PSR11MonoLog\Handler\BufferHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ChromePHPHandlerFactory;
use WShafer\PSR11MonoLog\Handler\CouchDBHandlerFactory;
use WShafer\PSR11MonoLog\Handler\CubeHandlerFactory;
use WShafer\PSR11MonoLog\Handler\DeduplicationHandlerFactory;
use WShafer\PSR11MonoLog\Handler\DoctrineCouchDBHandlerFactory;
use WShafer\PSR11MonoLog\Handler\DynamoDbHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ElasticaHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ErrorLogHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FallbackGroupHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FilterHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FingersCrossedHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FirePHPHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FleepHookHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FlowdockHandlerFactory;
use WShafer\PSR11MonoLog\Handler\GelfHandlerFactory;
use WShafer\PSR11MonoLog\Handler\GroupHandlerFactory;
use WShafer\PSR11MonoLog\Handler\HandlerMapper;
use WShafer\PSR11MonoLog\Handler\IFTTTHandlerFactory;
use WShafer\PSR11MonoLog\Handler\InsightOpsHandlerFactory;
use WShafer\PSR11MonoLog\Handler\LogEntriesHandlerFactory;
use WShafer\PSR11MonoLog\Handler\LogglyHandlerFactory;
use WShafer\PSR11MonoLog\Handler\LogmaticHandlerFactory;
use WShafer\PSR11MonoLog\Handler\MandrillHandlerFactory;
use WShafer\PSR11MonoLog\Handler\MongoDBHandlerFactory;
use WShafer\PSR11MonoLog\Handler\NativeMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\NewRelicHandlerFactory;
use WShafer\PSR11MonoLog\Handler\NoopHandlerFactory;
use WShafer\PSR11MonoLog\Handler\NullHandlerFactory;
use WShafer\PSR11MonoLog\Handler\OverflowHandlerFactory;
use WShafer\PSR11MonoLog\Handler\PHPConsoleHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ProcessHandlerFactory;
use WShafer\PSR11MonoLog\Handler\PsrHandlerFactory;
use WShafer\PSR11MonoLog\Handler\PushoverHandlerFactory;
use WShafer\PSR11MonoLog\Handler\RedisHandlerFactory;
use WShafer\PSR11MonoLog\Handler\RotatingFileHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SamplingHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SendGridHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SlackHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SlackWebhookHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SocketHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SqsHandlerFactory;
use WShafer\PSR11MonoLog\Handler\StreamHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SwiftMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SyslogHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SyslogUdpHandlerFactory;
use WShafer\PSR11MonoLog\Handler\TelegramBotHandlerFactory;
use WShafer\PSR11MonoLog\Handler\TestHandlerFactory;
use WShafer\PSR11MonoLog\Handler\WhatFailureGroupHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ZendMonitorHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\HandlerMapper
 */
class HandlerMapperTest extends TestCase
{
    /** @var HandlerMapper */
    protected $mapper;

    protected function setup(): void
    {
        $this->mapper = new HandlerMapper();
    }

    public function testMapStream()
    {
        $expected = StreamHandlerFactory::class;
        $result = $this->mapper->map('stream');
        $this->assertEquals($expected, $result);
    }

    public function testMapRotating()
    {
        $expected = RotatingFileHandlerFactory::class;
        $result = $this->mapper->map('rotating');
        $this->assertEquals($expected, $result);
    }

    public function testMapSyslog()
    {
        $expected = SyslogHandlerFactory::class;
        $result = $this->mapper->map('syslog');
        $this->assertEquals($expected, $result);
    }

    public function testMapErrorLog()
    {
        $expected = ErrorLogHandlerFactory::class;
        $result = $this->mapper->map('errorlog');
        $this->assertEquals($expected, $result);
    }

    public function testMapNativeMailer()
    {
        $expected = NativeMailerHandlerFactory::class;
        $result = $this->mapper->map('nativeMailer');
        $this->assertEquals($expected, $result);
    }

    public function testMapSwiftMailer()
    {
        $expected = SwiftMailerHandlerFactory::class;
        $result = $this->mapper->map('swiftMailer');
        $this->assertEquals($expected, $result);
    }

    public function testMapPushover()
    {
        $expected = PushoverHandlerFactory::class;
        $result = $this->mapper->map('pushover');
        $this->assertEquals($expected, $result);
    }

    public function testMapFlowdock()
    {
        $expected = FlowdockHandlerFactory::class;
        $result = $this->mapper->map('flowdock');
        $this->assertEquals($expected, $result);
    }

    public function testMapSlackWebhook()
    {
        $expected = SlackWebhookHandlerFactory::class;
        $result = $this->mapper->map('slackWebhook');
        $this->assertEquals($expected, $result);
    }

    public function testMapSlack()
    {
        $expected = SlackHandlerFactory::class;
        $result = $this->mapper->map('slack');
        $this->assertEquals($expected, $result);
    }

    public function testMapMandrill()
    {
        $expected = MandrillHandlerFactory::class;
        $result = $this->mapper->map('Mandrill');
        $this->assertEquals($expected, $result);
    }

    public function testMapFleepHook()
    {
        $expected = FleepHookHandlerFactory::class;
        $result = $this->mapper->map('fleepHook');
        $this->assertEquals($expected, $result);
    }

    public function testMapIFTTT()
    {
        $expected = IFTTTHandlerFactory::class;
        $result = $this->mapper->map('IFTTT');
        $this->assertEquals($expected, $result);
    }

    public function testMapSocket()
    {
        $expected = SocketHandlerFactory::class;
        $result = $this->mapper->map('socket');
        $this->assertEquals($expected, $result);
    }

    public function testMapAmqp()
    {
        $expected = AmqpHandlerFactory::class;
        $result = $this->mapper->map('amqp');
        $this->assertEquals($expected, $result);
    }

    public function testMapGelf()
    {
        $expected = GelfHandlerFactory::class;
        $result = $this->mapper->map('gelf');
        $this->assertEquals($expected, $result);
    }

    public function testMapCube()
    {
        $expected = CubeHandlerFactory::class;
        $result = $this->mapper->map('cube');
        $this->assertEquals($expected, $result);
    }

    public function testMapZend()
    {
        $expected = ZendMonitorHandlerFactory::class;
        $result = $this->mapper->map('zend');
        $this->assertEquals($expected, $result);
    }

    public function testMapNewRelic()
    {
        $expected = NewRelicHandlerFactory::class;
        $result = $this->mapper->map('newRelic');
        $this->assertEquals($expected, $result);
    }

    public function testMapLoggly()
    {
        $expected = LogglyHandlerFactory::class;
        $result = $this->mapper->map('loggly');
        $this->assertEquals($expected, $result);
    }

    public function testMapSyslogUdp()
    {
        $expected = SyslogUdpHandlerFactory::class;
        $result = $this->mapper->map('syslogUdp');
        $this->assertEquals($expected, $result);
    }

    public function testMapLogEntries()
    {
        $expected = LogEntriesHandlerFactory::class;
        $result = $this->mapper->map('logEntries');
        $this->assertEquals($expected, $result);
    }

    public function testMapFirePHP()
    {
        $expected = FirePHPHandlerFactory::class;
        $result = $this->mapper->map('firePHP');
        $this->assertEquals($expected, $result);
    }

    public function testMapChromePHP()
    {
        $expected = ChromePHPHandlerFactory::class;
        $result = $this->mapper->map('chromePHP');
        $this->assertEquals($expected, $result);
    }

    public function testMapBrowserConsole()
    {
        $expected = BrowserConsoleHandlerFactory::class;
        $result = $this->mapper->map('browserConsole');
        $this->assertEquals($expected, $result);
    }

    public function testMapPHPConsole()
    {
        $expected = PHPConsoleHandlerFactory::class;
        $result = $this->mapper->map('phpConsole');
        $this->assertEquals($expected, $result);
    }

    public function testMapRedis()
    {
        $expected = RedisHandlerFactory::class;
        $result = $this->mapper->map('redis');
        $this->assertEquals($expected, $result);
    }

    public function testMapMongo()
    {
        $expected = MongoDBHandlerFactory::class;
        $result = $this->mapper->map('mongo');
        $this->assertEquals($expected, $result);
    }

    public function testMapCouchDb()
    {
        $expected = CouchDBHandlerFactory::class;
        $result = $this->mapper->map('couchDb');
        $this->assertEquals($expected, $result);
    }

    public function testDoctrineCouchDb()
    {
        $expected = DoctrineCouchDBHandlerFactory::class;
        $result = $this->mapper->map('doctrineCouchDb');
        $this->assertEquals($expected, $result);
    }

    public function testElastica()
    {
        $expected = ElasticaHandlerFactory::class;
        $result = $this->mapper->map('elastica');
        $this->assertEquals($expected, $result);
    }

    public function testDynamoDb()
    {
        $expected = DynamoDbHandlerFactory::class;
        $result = $this->mapper->map('dynamoDb');
        $this->assertEquals($expected, $result);
    }

    public function testFingersCrossed()
    {
        $expected = FingersCrossedHandlerFactory::class;
        $result = $this->mapper->map('fingersCrossed');
        $this->assertEquals($expected, $result);
    }

    public function testDeduplication()
    {
        $expected = DeduplicationHandlerFactory::class;
        $result = $this->mapper->map('deduplication');
        $this->assertEquals($expected, $result);
    }

    public function testWhatFailureGroup()
    {
        $expected = WhatFailureGroupHandlerFactory::class;
        $result = $this->mapper->map('whatFailureGroupHandler');
        $this->assertEquals($expected, $result);
    }

    public function testBuffer()
    {
        $expected = BufferHandlerFactory::class;
        $result = $this->mapper->map('buffer');
        $this->assertEquals($expected, $result);
    }

    public function testGroup()
    {
        $expected = GroupHandlerFactory::class;
        $result = $this->mapper->map('group');
        $this->assertEquals($expected, $result);
    }

    public function testFilter()
    {
        $expected = FilterHandlerFactory::class;
        $result = $this->mapper->map('filter');
        $this->assertEquals($expected, $result);
    }

    public function testSampling()
    {
        $expected = SamplingHandlerFactory::class;
        $result = $this->mapper->map('sampling');
        $this->assertEquals($expected, $result);
    }

    public function testNull()
    {
        $expected = NullHandlerFactory::class;
        $result = $this->mapper->map('null');
        $this->assertEquals($expected, $result);
    }

    public function testPsr()
    {
        $expected = PsrHandlerFactory::class;
        $result = $this->mapper->map('psr');
        $this->assertEquals($expected, $result);
    }

    public function testProcess()
    {
        $expected = ProcessHandlerFactory::class;
        $result = $this->mapper->map('process');
        $this->assertEquals($expected, $result);
    }

    public function testSendGrid()
    {
        $expected = SendGridHandlerFactory::class;
        $result = $this->mapper->map('sendgrid');
        $this->assertEquals($expected, $result);
    }

    public function testTelegramBot()
    {
        $expected = TelegramBotHandlerFactory::class;
        $result = $this->mapper->map('telegrambot');
        $this->assertEquals($expected, $result);
    }

    public function testInsightOps()
    {
        $expected = InsightOpsHandlerFactory::class;
        $result = $this->mapper->map('insightops');
        $this->assertEquals($expected, $result);
    }

    public function testLogmatic()
    {
        $expected = LogmaticHandlerFactory::class;
        $result = $this->mapper->map('logmatic');
        $this->assertEquals($expected, $result);
    }

    public function testSQS()
    {
        $expected = SqsHandlerFactory::class;
        $result = $this->mapper->map('sqs');
        $this->assertEquals($expected, $result);
    }

    public function testFallbackGroup()
    {
        $expected = FallbackGroupHandlerFactory::class;
        $result = $this->mapper->map('fallbackgroup');
        $this->assertEquals($expected, $result);
    }

    public function testNoop()
    {
        $expected = NoopHandlerFactory::class;
        $result = $this->mapper->map('noop');
        $this->assertEquals($expected, $result);
    }

    public function testOverflow()
    {
        $expected = OverflowHandlerFactory::class;
        $result = $this->mapper->map('overflow');
        $this->assertEquals($expected, $result);
    }

    public function testTest()
    {
        $expected = TestHandlerFactory::class;
        $result = $this->mapper->map('test');
        $this->assertEquals($expected, $result);
    }

    public function testMapNotFound()
    {
        $result = $this->mapper->map('notHere');
        $this->assertNull($result);
    }
}
