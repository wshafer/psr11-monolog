<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\AmqpHandlerFactory;
use WShafer\PSR11MonoLog\Handler\BrowserConsoleHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ChromePHPHandlerFactory;
use WShafer\PSR11MonoLog\Handler\CouchDBHandlerFactory;
use WShafer\PSR11MonoLog\Handler\CubeHandlerFactory;
use WShafer\PSR11MonoLog\Handler\DoctrineCouchDBHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ErrorLogHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FirePHPHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FleepHookHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FlowdockHandlerFactory;
use WShafer\PSR11MonoLog\Handler\GelfHandlerFactory;
use WShafer\PSR11MonoLog\Handler\HandlerMapper;
use WShafer\PSR11MonoLog\Handler\HipChatHandlerFactory;
use WShafer\PSR11MonoLog\Handler\IFTTTHandlerFactory;
use WShafer\PSR11MonoLog\Handler\LogEntriesHandlerFactory;
use WShafer\PSR11MonoLog\Handler\LogglyHandlerFactory;
use WShafer\PSR11MonoLog\Handler\MandrillHandlerFactory;
use WShafer\PSR11MonoLog\Handler\MongoDBHandlerFactory;
use WShafer\PSR11MonoLog\Handler\NativeMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\NewRelicHandlerFactory;
use WShafer\PSR11MonoLog\Handler\PHPConsoleHandlerFactory;
use WShafer\PSR11MonoLog\Handler\PushoverHandlerFactory;
use WShafer\PSR11MonoLog\Handler\RavenHandlerFactory;
use WShafer\PSR11MonoLog\Handler\RedisHandlerFactory;
use WShafer\PSR11MonoLog\Handler\RotatingFileHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SlackbotHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SlackHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SlackWebhookHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SocketHandlerFactory;
use WShafer\PSR11MonoLog\Handler\StreamHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SwiftMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SyslogHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SyslogUdpHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ZendMonitorHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\HandlerMapper
 */
class HandlerMapperTest extends TestCase
{
    /** @var HandlerMapper */
    protected $mapper;

    public function setup()
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

    public function testMapHipChat()
    {
        $expected = HipChatHandlerFactory::class;
        $result = $this->mapper->map('hipChat');
        $this->assertEquals($expected, $result);
    }

    public function testMapFlowdock()
    {
        $expected = FlowdockHandlerFactory::class;
        $result = $this->mapper->map('flowdock');
        $this->assertEquals($expected, $result);
    }

    public function testMapSlackBot()
    {
        $expected = SlackbotHandlerFactory::class;
        $result = $this->mapper->map('slackbot');
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

    public function testMapRaven()
    {
        $expected = RavenHandlerFactory::class;
        $result = $this->mapper->map('raven');
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
        $result = $this->mapper->map('doctrinecouchdb');
        $this->assertEquals($expected, $result);
    }

    public function testMapNotFound()
    {
        $result = $this->mapper->map('notHere');
        $this->assertNull($result);
    }
}
