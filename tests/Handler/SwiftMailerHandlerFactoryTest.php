<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SwiftMailerHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Swift_Mailer;
use Swift_Message;
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

        $mockMailer = $this->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockMessage = $this->getMockBuilder(Swift_Message::class)
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
}
