<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SwiftMailerHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\SwiftMailerHandlerFactory;

class SwiftMailerHandlerFactoryTest extends TestCase
{
    public function testGetSetContainer()
    {
        $mockContainer = $this->createMock(ContainerInterface::class);

        $factory = new SwiftMailerHandlerFactory();
        $factory->setContainer($mockContainer);
        $container = $factory->getContainer();

        $this->assertEquals($mockContainer, $container);
    }


    public function testInvokeWithServices()
    {
        $options = [
            'mailer' => 'my-service',
            'message' => 'my-message',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockMessage = $this->getMockBuilder(\Swift_Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hasMap = [
            ['my-service', true],
            ['my-message', true],
        ];

        $mockContainer->expects($this->exactly(2))
            ->method('has')
            ->will($this->returnValueMap($hasMap));

        $getMap = [
            ['my-service', $mockMailer],
            ['my-message', $mockMessage],
        ];

        $mockContainer->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnValueMap($getMap));

        $factory = new SwiftMailerHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);

        $this->assertInstanceOf(SwiftMailerHandler::class, $handler);
    }

    public function testInvokeWithCallableMessage()
    {
        $options = [
            'mailer' => 'my-service',
            'message' => function () {
                return true;
            },
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hasMap = [
            ['my-service', true],
        ];

        $mockContainer->expects($this->exactly(1))
            ->method('has')
            ->will($this->returnValueMap($hasMap));

        $getMap = [
            ['my-service', $mockMailer]
        ];

        $mockContainer->expects($this->exactly(1))
            ->method('get')
            ->will($this->returnValueMap($getMap));

        $factory = new SwiftMailerHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);

        $this->assertInstanceOf(SwiftMailerHandler::class, $handler);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testInvokeWithMissingMailerConfig()
    {
        $options = [
            'message' => 'my-message',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockMessage = $this->getMockBuilder(\Swift_Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hasMap = [
            ['my-service', true],
            ['my-message', true],
        ];

        $mockContainer->expects($this->never())
            ->method('has');

        $getMap = [
            ['my-service', $mockMailer],
            ['my-message', $mockMessage],
        ];

        $mockContainer->expects($this->never())
            ->method('get');

        $factory = new SwiftMailerHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testInvokeWithMissingMailerService()
    {
        $options = [
            'mailer' => 'my-service',
            'message' => 'my-message',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockMessage = $this->getMockBuilder(\Swift_Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hasMap = [
            ['my-service', false],
            ['my-message', true],
        ];

        $mockContainer->expects($this->exactly(1))
            ->method('has')
            ->will($this->returnValueMap($hasMap));

        $mockContainer->expects($this->never())
            ->method('get');

        $factory = new SwiftMailerHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testInvokeWithMissingMessageConfig()
    {
        $options = [
            'mailer' => 'my-service',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockMessage = $this->getMockBuilder(\Swift_Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hasMap = [
            ['my-service', true],
            ['my-message', false],
        ];

        $mockContainer->expects($this->exactly(1))
            ->method('has')
            ->will($this->returnValueMap($hasMap));

        $getMap = [
            ['my-service', $mockMailer],
            ['my-message', $mockMessage],
        ];

        $mockContainer->expects($this->exactly(1))
            ->method('get')
            ->will($this->returnValueMap($getMap));

        $factory = new SwiftMailerHandlerFactory();
        $factory->setContainer($mockContainer);
        $factory($options);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testInvokeWithMissingMessageService()
    {
        $options = [
            'mailer' => 'my-service',
            'message' => 'my-message',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockMessage = $this->getMockBuilder(\Swift_Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hasMap = [
            ['my-service', true],
            ['my-message', false],
        ];

        $mockContainer->expects($this->exactly(2))
            ->method('has')
            ->will($this->returnValueMap($hasMap));

        $getMap = [
            ['my-service', $mockMailer],
            ['my-message', $mockMessage],
        ];

        $mockContainer->expects($this->exactly(1))
            ->method('get')
            ->will($this->returnValueMap($getMap));

        $factory = new SwiftMailerHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);
    }
}
