<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\FingersCrossed\ActivationStrategyInterface;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\FingersCrossedHandlerFactory;
use WShafer\PSR11MonoLog\Service\HandlerManager;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\FingersCrossedHandlerFactory
 */
class FingersCrossedHandlerFactoryTest extends TestCase
{
    /** @var FingersCrossedHandlerFactory */
    protected $factory;

    /** @var MockObject|ContainerInterface */
    protected $mockContainer;

    /** @var MockObject|HandlerManager */
    protected $mockHandlerManager;

    protected function setup(): void
    {
        $this->factory = new FingersCrossedHandlerFactory();

        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);

        $this->mockHandlerManager = $this->getMockBuilder(HandlerManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory->setHandlerManager($this->mockHandlerManager);
    }

    public function testInvoke()
    {
        $options = [
            'handler'            => 'my-handler',
            'activationStrategy' => 'my-strategy',
            'bufferSize'         => 0,
            'bubble'             => false,
            'stopBuffering'      => true,
            'passthruLevel'      => Logger::CRITICAL
        ];

        $mockService = $this->createMock(ActivationStrategyInterface::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-strategy'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-strategy'))
            ->willReturn($mockService);


        $mockHandler = $this->createMock(HandlerInterface::class);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-handler'))
            ->willReturn($mockHandler);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(FingersCrossedHandler::class, $handler);
    }

    public function testGetActivationWithNull()
    {
        $options = [
            'handler'            => 'my-handler',
            'activationStrategy' => null,
            'bufferSize'         => 0,
            'bubble'             => false,
            'stopBuffering'      => true,
            'passthruLevel'      => Logger::CRITICAL
        ];

        $this->mockContainer->expects($this->never())
            ->method('has');

        $this->mockContainer->expects($this->never())
            ->method('get');

        $mockHandler = $this->createMock(HandlerInterface::class);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-handler'))
            ->willReturn($mockHandler);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(FingersCrossedHandler::class, $handler);
    }

    public function testGetActivationWithErrorLevel()
    {
        $options = [
            'handler'            => 'my-handler',
            'activationStrategy' => Logger::CRITICAL,
            'bufferSize'         => 0,
            'bubble'             => false,
            'stopBuffering'      => true,
            'passthruLevel'      => Logger::CRITICAL
        ];

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with(Logger::CRITICAL)
            ->willReturn(false);

        $this->mockContainer->expects($this->never())
            ->method('get');

        $mockHandler = $this->createMock(HandlerInterface::class);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-handler'))
            ->willReturn($mockHandler);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(FingersCrossedHandler::class, $handler);
    }
}
