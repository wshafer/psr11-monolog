<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\DeduplicationHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\DeduplicationHandlerFactory;
use WShafer\PSR11MonoLog\Service\HandlerManager;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\DeduplicationHandlerFactory
 */
class DeduplicationHandlerFactoryTest extends TestCase
{
    /** @var DeduplicationHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|HandlerManager */
    protected $mockHandlerManager;

    public function setup()
    {
        $this->factory = new DeduplicationHandlerFactory();

        $this->mockHandlerManager = $this->getMockBuilder(HandlerManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory->setHandlerManager($this->mockHandlerManager);
    }

    public function testInvoke()
    {
        $options = [
            'handler'            => 'my-handler',
            'deduplicationStore' => '/tmp/store',
            'deduplicationLevel' => Logger::DEBUG,
            'time'               => 2
        ];

        $mockHandler = $this->createMock(HandlerInterface::class);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-handler'))
            ->willReturn($mockHandler);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(DeduplicationHandler::class, $handler);
    }
}
