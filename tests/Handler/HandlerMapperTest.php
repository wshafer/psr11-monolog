<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\AmqpHandlerFactory;
use WShafer\PSR11MonoLog\Handler\ErrorLogHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FleepHookHandlerFactory;
use WShafer\PSR11MonoLog\Handler\FlowdockHandlerFactory;
use WShafer\PSR11MonoLog\Handler\HandlerMapper;
use WShafer\PSR11MonoLog\Handler\HipChatHandlerFactory;
use WShafer\PSR11MonoLog\Handler\IFTTTHandlerFactory;
use WShafer\PSR11MonoLog\Handler\MandrillHandlerFactory;
use WShafer\PSR11MonoLog\Handler\NativeMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\PushoverHandlerFactory;
use WShafer\PSR11MonoLog\Handler\RotatingFileHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SlackbotHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SlackHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SlackWebhookHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SocketHandlerFactory;
use WShafer\PSR11MonoLog\Handler\StreamHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SwiftMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SyslogHandlerFactory;

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

    public function testMapNotFound()
    {
        $result = $this->mapper->map('notHere');
        $this->assertNull($result);
    }
}
