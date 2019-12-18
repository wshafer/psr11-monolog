<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Aws\Sqs\SqsClient;
use Monolog\Handler\SqsHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\Handler\SqsHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SqsHandlerFactory
 */
class SqsHandlerFactoryTest extends TestCase
{
    /** @var SqsHandlerFactory */
    protected $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $mockContainer;

    public function setup()
    {
        $this->factory = new SqsHandlerFactory();
        $this->mockContainer = $this->createMock(ContainerInterface::class);
        $this->factory->setContainer($this->mockContainer);
    }

    public function testInvoke()
    {
        $options = [
            'sqsClient' => 'my-service',
            'queueUrl'  => 'logger',
            'level'     => Logger::INFO,
            'bubble'    => false,
        ];

        $mockService = $this->createMock(SqsClient::class);

        $this->mockContainer->expects($this->once())
            ->method('has')
            ->with($this->equalTo('my-service'))
            ->willReturn(true);

        $this->mockContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('my-service'))
            ->willReturn($mockService);

        $handler = $this->factory->__invoke($options);

        $this->assertInstanceOf(SqsHandler::class, $handler);
    }
}
