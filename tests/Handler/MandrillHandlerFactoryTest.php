<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\MandrillHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\MandrillHandlerFactory;

class MandrillHandlerFactoryTest extends TestCase
{
    public function testGetSetContainer()
    {
        $mockContainer = $this->createMock(ContainerInterface::class);

        $factory = new MandrillHandlerFactory();
        $factory->setContainer($mockContainer);
        $container = $factory->getContainer();

        $this->assertEquals($mockContainer, $container);
    }


    public function testInvokeWithMessageService()
    {
        $options = [
            'apiKey' => 'my-api-key',
            'message' => 'my-message',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMessage = $this->getMockBuilder(\Swift_Message::class)
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

    public function testInvokeWithCallableMessage()
    {
        $mockMessage = $this->getMockBuilder(\Swift_Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $options = [
            'apiKey' => 'my-api-key',
            'message' => function () use ($mockMessage) {
                return $mockMessage;
            },
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockContainer->expects($this->never())
            ->method('has');

        $factory = new MandrillHandlerFactory();
        $factory->setContainer($mockContainer);

        $handler = $factory($options);

        $this->assertInstanceOf(MandrillHandler::class, $handler);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testInvokeWithMissingMessageConfig()
    {
        $options = [
            'apiKey' => 'my-api-key',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockContainer->expects($this->never())
            ->method('has');

        $mockContainer->expects($this->never())
            ->method('get');

        $factory = new MandrillHandlerFactory();
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

        $hasMap = [
            ['my-message', false],
        ];

        $mockContainer->expects($this->once())
            ->method('has')
            ->will($this->returnValueMap($hasMap));

        $mockContainer->expects($this->never())
            ->method('get');

        $factory = new MandrillHandlerFactory();
        $factory->setContainer($mockContainer);

        $factory($options);
    }
}
