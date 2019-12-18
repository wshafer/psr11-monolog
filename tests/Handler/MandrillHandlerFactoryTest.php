<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\MandrillHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Swift_Message;
use WShafer\PSR11MonoLog\Handler\MandrillHandlerFactory;

class MandrillHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'apiKey' => 'my-api-key',
            'message' => 'my-message',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMessage = $this->getMockBuilder(Swift_Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $hasMap = [
            ['my-message', true],
        ];

        $mockContainer->expects($this->once())
            ->method('has')
            ->will($this->returnValueMap($hasMap));

        $getMap = [
            ['my-message', $mockMessage],
        ];

        $mockContainer->expects($this->once())
            ->method('get')
            ->will($this->returnValueMap($getMap));

        $factory = new MandrillHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);

        $this->assertInstanceOf(MandrillHandler::class, $handler);
    }
}
