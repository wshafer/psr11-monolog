<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SwiftMailerHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\SwiftMailerHandlerFactory;
use WShafer\PSR11MonoLog\Handler\SwiftMessageTrait;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SwiftMessageTrait
 */
class SwiftMessageTraitTest extends TestCase
{
    /** @var SwiftMessageTrait */
    protected $trait;

    public function setup()
    {
        $this->trait = $this->getMockForTrait(SwiftMessageTrait::class);
    }

    public function testGetSwiftMessageWithCallableMessage()
    {
        $options = [
            'message' => function () {
                return true;
            },
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockContainer->expects($this->never())
            ->method('has');

        $mockContainer->expects($this->never())
            ->method('get');

        $this->trait->setContainer($mockContainer);
        $message = $this->trait->getSwiftMessage($options);

        $this->assertEquals($options['message'], $message);
    }

    public function testGetSwiftMessageWithService()
    {
        $options = [
            'message' => 'my-service',
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockMessage = $this->createMock(\Swift_Message::class);

        $mockContainer->expects($this->once())
            ->method('has')
            ->with('my-service')
            ->willReturn(true);

        $mockContainer->expects($this->once())
            ->method('get')
            ->with('my-service')
            ->willReturn($mockMessage);

        $this->trait->setContainer($mockContainer);
        $message = $this->trait->getSwiftMessage($options);


        $this->assertEquals($mockMessage, $message);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingConfigException
     */
    public function testInvokeWithMissingMailerConfig()
    {
        $options = [];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockContainer->expects($this->never())
            ->method('has');

        $mockContainer->expects($this->never())
            ->method('get');

        $this->trait->setContainer($mockContainer);
        $this->trait->getSwiftMessage($options);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\MissingServiceException
     */
    public function testInvokeWithMissingMailerService()
    {
        $options = [
            'message' => 'my-message',
        ];

        $mockContainer = $this->createMock(ContainerInterface::class);

        $mockContainer->expects($this->exactly(1))
            ->method('has')
            ->with($this->equalTo('my-message'))
            ->willReturn(null);

        $mockContainer->expects($this->never())
            ->method('get');

        $this->trait->setContainer($mockContainer);
        $this->trait->getSwiftMessage($options);
    }
}
