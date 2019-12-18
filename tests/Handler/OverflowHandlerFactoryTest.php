<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\OverflowHandler;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Exception\UnknownServiceException;
use WShafer\PSR11MonoLog\Handler\OverflowHandlerFactory;
use WShafer\PSR11MonoLog\Service\HandlerManager;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\OverflowHandlerFactory
 */
class OverflowHandlerFactoryTest extends TestCase
{
    /** @var OverflowHandlerFactory */
    protected $factory;

    /** @var MockObject|HandlerManager */
    protected $mockHandlerManager;

    protected function setup(): void
    {
        $this->factory = new OverflowHandlerFactory();

        $this->mockHandlerManager = $this->getMockBuilder(HandlerManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory->setHandlerManager($this->mockHandlerManager);
    }

    public function testInvoke()
    {
        $options = [
            'handler'  => 'my-handler-one',
            'thresholdMap' => [
                'debug' => 2,
                'info' => 2,
                'notice' => 2,
                'warning' => 2,
                'error' => 2,
                'critical' => 2,
                'alert' => 2,
                'emergency' => 2,
            ],
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $mockHandler = $this->createMock(HandlerInterface::class);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-handler-one'))
            ->willReturn($mockHandler);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(OverflowHandler::class, $handler);
    }

    public function testInvokeMissingHandlers()
    {
        $this->expectException(UnknownServiceException::class);

        $options = [
            'handler'  => 'my-handler-two',
            'thresholdMap' => [
                'debug' => 2,
                'info' => 2,
                'notice' => 2,
                'warning' => 2,
                'error' => 2,
                'critical' => 2,
                'alert' => 2,
                'emergency' => 2,
            ],
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-handler-two'))
            ->willThrowException(new UnknownServiceException('Unit test'));

        $this->factory->__invoke($options);
    }
}
