<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\IntrospectionProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\IntrospectionProcessorFactory
 */
class IntrospectionProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'level'                => Logger::INFO,
            'skipClassesPartials'  => [],
            'skipStackFramesCount' => 0
        ];

        $factory = new IntrospectionProcessorFactory();
        $handler = $factory($options);
        $this->assertInstanceOf(IntrospectionProcessor::class, $handler);
    }
}
