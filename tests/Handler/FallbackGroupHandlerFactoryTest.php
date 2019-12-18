<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\FallbackGroupHandler;
use Monolog\Handler\HandlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Handler\FallbackGroupHandlerFactory;
use WShafer\PSR11MonoLog\Service\HandlerManager;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\FallbackGroupHandlerFactory
 */
class FallbackGroupHandlerFactoryTest extends TestCase
{
    /** @var FallbackGroupHandlerFactory */
    protected $factory;

    /** @var MockObject|HandlerManager */
    protected $mockHandlerManager;

    protected function setup(): void
    {
        $this->factory = new FallbackGroupHandlerFactory();

        $this->mockHandlerManager = $this->getMockBuilder(HandlerManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory->setHandlerManager($this->mockHandlerManager);
    }

    public function testInvoke()
    {
        $options = [
            'handlers'  => [
                'my-handler-one',
                'my-handler-two',
            ],

            'bubble' => true,
        ];

        $mockHandler = $this->createMock(HandlerInterface::class);

        $map = [
            ['my-handler-one', $mockHandler],
            ['my-handler-two', $mockHandler],
        ];

        $this->mockHandlerManager->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnValueMap($map));

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(FallbackGroupHandler::class, $handler);
    }

    public function testInvokeMissingHandlers()
    {
        $this->expectException(MissingConfigException::class);

        $options = [
            'handlers'  => [],
            'bubble' => true,
        ];

        $this->mockHandlerManager->expects($this->never())
            ->method('get');

        $this->factory->__invoke($options);
    }

    public function testInvokeMissingHandlersKey()
    {
        $this->expectException(MissingConfigException::class);

        $options = [
            'bubble' => true,
        ];

        $this->mockHandlerManager->expects($this->never())
            ->method('get');

        $this->factory->__invoke($options);
    }
}
