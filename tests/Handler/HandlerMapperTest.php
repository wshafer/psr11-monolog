<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\NullHandler;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\ErrorLogHandlerFactory;
use WShafer\PSR11MonoLog\Handler\HandlerMapper;
use WShafer\PSR11MonoLog\Handler\NativeMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\PushoverHandlerFactory;
use WShafer\PSR11MonoLog\Handler\RotatingFileHandlerFactory;
use WShafer\PSR11MonoLog\Handler\StreamHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SwiftMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SyslogHandlerFactory;

class HandlerMapperTest extends TestCase
{
    /** @var HandlerMapper */
    protected $mapper;

    public function setup()
    {
        $mockContainer = $this->createMock(ContainerInterface::class);
        $this->mapper = new HandlerMapper($mockContainer);
    }

    public function testGetFactoryClassNameFullClassName()
    {
        $expected = NullHandler::class;
        $result = $this->mapper->getFactoryClassName($expected);
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameStream()
    {
        $expected = StreamHandlerFactory::class;
        $result = $this->mapper->getFactoryClassName('stream');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameRotating()
    {
        $expected = RotatingFileHandlerFactory::class;
        $result = $this->mapper->getFactoryClassName('rotating');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameSyslog()
    {
        $expected = SyslogHandlerFactory::class;
        $result = $this->mapper->getFactoryClassName('syslog');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameErrorLog()
    {
        $expected = ErrorLogHandlerFactory::class;
        $result = $this->mapper->getFactoryClassName('errorlog');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameNativeMailer()
    {
        $expected = NativeMailerHandlerFactory::class;
        $result = $this->mapper->getFactoryClassName('nativeMailer');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameSwiftMailer()
    {
        $expected = SwiftMailerHandlerFactory::class;
        $result = $this->mapper->getFactoryClassName('swiftMailer');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNamePushover()
    {
        $expected = PushoverHandlerFactory::class;
        $result = $this->mapper->getFactoryClassName('pushover');
        $this->assertEquals($expected, $result);
    }

    public function testGetFactoryClassNameNotFound()
    {
        $result = $this->mapper->getFactoryClassName('notHere');
        $this->assertNull($result);
    }
}
