<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Processor\TagProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\TagProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\TagProcessorFactory
 */
class TagProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = ['tags' => []];
        $factory = new TagProcessorFactory();
        $handler = $factory($options);
        $this->assertInstanceOf(TagProcessor::class, $handler);
    }
}
