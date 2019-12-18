<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\ChannelChanger;
use WShafer\PSR11MonoLog\Config\ChannelConfig;
use WShafer\PSR11MonoLog\Config\MainConfig;
use WShafer\PSR11MonoLog\Exception\MissingConfigException;
use WShafer\PSR11MonoLog\Exception\UnknownServiceException;
use WShafer\PSR11MonoLog\Service\HandlerManager;
use WShafer\PSR11MonoLog\Service\ProcessorManager;

/**
 * @covers \WShafer\PSR11MonoLog\ChannelChanger
 */
class ChannelChangerTest extends TestCase
{
    use ConfigTrait;

    /** @var ChannelChanger */
    protected $service;

    /** @var MockObject|MainConfig */
    protected $mockConfig;

    /** @var MockObject|HandlerManager */
    protected $mockHandlerManager;

    /** @var MockObject|ProcessorManager */
    protected $mockProcessorManager;

    /** @var MockObject|ChannelConfig */
    protected $mockChannelConfig;

    /** @var MockObject|HandlerInterface */
    protected $mockHandler;

    /** @var MockObject|PsrLogMessageProcessor */
    protected $mockProcessor;

    protected function setup(): void
    {
        $this->mockConfig = $this->getMockBuilder(MainConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockHandlerManager = $this->getMockBuilder(HandlerManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockProcessorManager = $this->getMockBuilder(ProcessorManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockChannelConfig = $this->getMockBuilder(ChannelConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockHandler = $this->getMockBuilder(StreamHandler::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockProcessor = $this->getMockBuilder(PsrLogMessageProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new ChannelChanger(
            $this->mockConfig,
            $this->mockHandlerManager,
            $this->mockProcessorManager
        );

        $this->assertInstanceOf(ChannelChanger::class, $this->service);
    }

    public function testConstructor()
    {
    }

    public function testHas()
    {
        $this->mockConfig->expects($this->once())
            ->method('hasChannelConfig')
            ->with('myChannel')
            ->willReturn(true);

        $result = $this->service->has('myChannel');
        $this->assertTrue($result);
    }

    public function testGet()
    {
        $this->mockConfig->expects($this->once())
            ->method('hasChannelConfig')
            ->with('myChannel')
            ->willReturn(true);

        $this->mockConfig->expects($this->once())
            ->method('getChannelConfig')
            ->with('myChannel')
            ->willReturn($this->mockChannelConfig);

        /* Handler */
        $this->mockChannelConfig->expects($this->once())
            ->method('getHandlers')
            ->willReturn(['myHandler']);

        $this->mockHandlerManager->expects($this->once())
            ->method('has')
            ->with('myHandler')
            ->willReturn(true);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with('myHandler')
            ->willReturn($this->mockHandler);

        /* Processor */
        $this->mockChannelConfig->expects($this->once())
            ->method('getProcessors')
            ->willReturn(['myProcessor']);

        $this->mockProcessorManager->expects($this->once())
            ->method('has')
            ->with('myProcessor')
            ->willReturn(true);

        $this->mockProcessorManager->expects($this->once())
            ->method('get')
            ->with('myProcessor')
            ->willReturn($this->mockProcessor);

        /* Name */
        $this->mockChannelConfig->expects($this->once())
            ->method('getName')
            ->willReturn(null);

        /** @var Logger $result */
        $result = $this->service->get('myChannel');
        $this->assertInstanceOf(Logger::class, $result);

        $handlers = $result->getHandlers();
        $this->assertEquals($this->mockHandler, $handlers[0]);

        $processors = $result->getProcessors();
        $this->assertEquals($this->mockProcessor, $processors[0]);

        $name = $result->getName();
        $this->assertEquals('myChannel', $name);
    }

    public function testGetFromCache()
    {
        $this->mockConfig->expects($this->once())
            ->method('hasChannelConfig')
            ->with('myChannel')
            ->willReturn(true);

        $this->mockConfig->expects($this->once())
            ->method('getChannelConfig')
            ->with('myChannel')
            ->willReturn($this->mockChannelConfig);

        /* Handler */
        $this->mockChannelConfig->expects($this->once())
            ->method('getHandlers')
            ->willReturn(['myHandler']);

        $this->mockHandlerManager->expects($this->once())
            ->method('has')
            ->with('myHandler')
            ->willReturn(true);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with('myHandler')
            ->willReturn($this->mockHandler);

        /* Processor */
        $this->mockChannelConfig->expects($this->once())
            ->method('getProcessors')
            ->willReturn(['myProcessor']);

        $this->mockProcessorManager->expects($this->once())
            ->method('has')
            ->with('myProcessor')
            ->willReturn(true);

        $this->mockProcessorManager->expects($this->once())
            ->method('get')
            ->with('myProcessor')
            ->willReturn($this->mockProcessor);

        /* Name */
        $this->mockChannelConfig->expects($this->once())
            ->method('getName')
            ->willReturn(null);

        /** @var Logger $result */
        $result = $this->service->get('myChannel');
        $this->assertInstanceOf(Logger::class, $result);

        /* Should not call mocks again */
        $result = $this->service->get('myChannel');
        $this->assertInstanceOf(Logger::class, $result);
    }

    public function testGetWithMissingChannelConfig()
    {
        $this->expectException(MissingConfigException::class);
        $this->mockConfig->expects($this->once())
            ->method('hasChannelConfig')
            ->with('myChannel')
            ->willReturn(false);

        $this->mockConfig->expects($this->never())
            ->method('getChannelConfig');

        /* Handler */
        $this->mockChannelConfig->expects($this->never())
            ->method('getHandlers');

        $this->mockHandlerManager->expects($this->never())
            ->method('has');

        $this->mockHandlerManager->expects($this->never())
            ->method('get');

        /* Processor */
        $this->mockChannelConfig->expects($this->never())
            ->method('getProcessors');

        $this->mockProcessorManager->expects($this->never())
            ->method('has');

        $this->mockProcessorManager->expects($this->never())
            ->method('get');

        /* Name */
        $this->mockChannelConfig->expects($this->never())
            ->method('getName');

        /** @var Logger $result */
        $result = $this->service->get('myChannel');
        $this->assertInstanceOf(Logger::class, $result);
    }

    public function testGetWithMissingHandler()
    {
        $this->expectException(UnknownServiceException::class);

        $this->mockConfig->expects($this->once())
            ->method('hasChannelConfig')
            ->with('myChannel')
            ->willReturn(true);

        $this->mockConfig->expects($this->once())
            ->method('getChannelConfig')
            ->with('myChannel')
            ->willReturn($this->mockChannelConfig);

        /* Handler */
        $this->mockChannelConfig->expects($this->once())
            ->method('getHandlers')
            ->willReturn(['myHandler']);

        $this->mockHandlerManager->expects($this->once())
            ->method('has')
            ->with('myHandler')
            ->willReturn(false);

        $this->mockHandlerManager->expects($this->never())
            ->method('get');

        /* Processor */
        $this->mockChannelConfig->expects($this->never())
            ->method('getProcessors');

        $this->mockProcessorManager->expects($this->never())
            ->method('has');

        $this->mockProcessorManager->expects($this->never())
            ->method('get');

        /* Name */
        $this->mockChannelConfig->expects($this->once())
            ->method('getName')
            ->willReturn(null);

        /** @var Logger $result */
        $result = $this->service->get('myChannel');
        $this->assertInstanceOf(Logger::class, $result);
    }

    public function testGetWithMissingProcessor()
    {
        $this->expectException(UnknownServiceException::class);

        $this->mockConfig->expects($this->once())
            ->method('hasChannelConfig')
            ->with('myChannel')
            ->willReturn(true);

        $this->mockConfig->expects($this->once())
            ->method('getChannelConfig')
            ->with('myChannel')
            ->willReturn($this->mockChannelConfig);

        /* Handler */
        $this->mockChannelConfig->expects($this->once())
            ->method('getHandlers')
            ->willReturn(['myHandler']);

        $this->mockHandlerManager->expects($this->once())
            ->method('has')
            ->with('myHandler')
            ->willReturn(true);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with('myHandler')
            ->willReturn($this->mockHandler);

        /* Processor */
        $this->mockChannelConfig->expects($this->once())
            ->method('getProcessors')
            ->willReturn(['myProcessor']);

        $this->mockProcessorManager->expects($this->once())
            ->method('has')
            ->with('myProcessor')
            ->willReturn(false);

        $this->mockProcessorManager->expects($this->never())
            ->method('get');

        /* Name */
        $this->mockChannelConfig->expects($this->once())
            ->method('getName')
            ->willReturn(null);

        /** @var Logger $result */
        $result = $this->service->get('myChannel');
        $this->assertInstanceOf(Logger::class, $result);
    }

    public function testGetWithCustomName()
    {
        $this->mockConfig->expects($this->once())
            ->method('hasChannelConfig')
            ->with('myChannel')
            ->willReturn(true);

        $this->mockConfig->expects($this->once())
            ->method('getChannelConfig')
            ->with('myChannel')
            ->willReturn($this->mockChannelConfig);

        /* Handler */
        $this->mockChannelConfig->expects($this->once())
            ->method('getHandlers')
            ->willReturn(['myHandler']);

        $this->mockHandlerManager->expects($this->once())
            ->method('has')
            ->with('myHandler')
            ->willReturn(true);

        $this->mockHandlerManager->expects($this->once())
            ->method('get')
            ->with('myHandler')
            ->willReturn($this->mockHandler);

        /* Processor */
        $this->mockChannelConfig->expects($this->once())
            ->method('getProcessors')
            ->willReturn(['myProcessor']);

        $this->mockProcessorManager->expects($this->once())
            ->method('has')
            ->with('myProcessor')
            ->willReturn(true);

        $this->mockProcessorManager->expects($this->once())
            ->method('get')
            ->with('myProcessor')
            ->willReturn($this->mockProcessor);

        /* Name */
        $this->mockChannelConfig->expects($this->once())
            ->method('getName')
            ->willReturn('customName');

        /** @var Logger $result */
        $result = $this->service->get('myChannel');
        $this->assertInstanceOf(Logger::class, $result);

        $name = $result->getName();

        $this->assertEquals('customName', $name);
    }
}
