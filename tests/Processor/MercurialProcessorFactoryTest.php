<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Logger;
use Monolog\Processor\MercurialProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\MercurialProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\MercurialProcessorFactory
 */
class MercurialProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = ['level' => Logger::INFO];

        $factory = new MercurialProcessorFactory();
        $handler = $factory($options);
        $this->assertInstanceOf(MercurialProcessor::class, $handler);
    }
}
