<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SwiftMailerHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\SwiftMailerHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SwiftMailerHandlerFactory
 */
class SwiftMailerHandlerFactoryTest extends TestCase
{
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

        $mockContainer->expects($this->never())
            ->method('has');

        $mockContainer->expects($this->never())
            ->method('get');

        $factory = new SwiftMailerHandlerFactory();
        $factory->setContainer($mockContainer);

        $factory($options);
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
}
