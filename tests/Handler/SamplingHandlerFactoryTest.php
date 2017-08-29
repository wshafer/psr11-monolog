<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SamplingHandler;
use Monolog\Handler\HandlerInterface;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\SamplingHandlerFactory;
use WShafer\PSR11MonoLog\Service\HandlerManager;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SamplingHandlerFactory
 */
class SamplingHandlerFactoryTest extends TestCase
{
    /** @var SamplingHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|HandlerManager */
    protected $mockHandlerManager;

    public function setup()
    {
        $this->factory = new SamplingHandlerFactory();

        $this->mockHandlerManager = $this->getMockBuilder(HandlerManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory->setHandlerManager($this->mockHandlerManager);
    }

    public function testInvoke()
    {
        $options = [
            'handler'=> 'my-handler',
            'factor' => 5,
        ];

        $mockHandler = $this->createMock(HandlerInterface::class);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-handler'))
            ->willReturn($mockHandler);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(SamplingHandler::class, $handler);
    }

    /**
     * @expectedException \WShafer\PSR11MonoLog\Exception\InvalidConfigException
     */
    public function testInvokeErrorsWithNoFactor()
    {
        $options = [
            'handler'=> 'my-handler',
        ];

        $mockHandler = $this->createMock(HandlerInterface::class);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-handler'))
            ->willReturn($mockHandler);

        $this->factory->__invoke($options);
    }
}
