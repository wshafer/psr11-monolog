<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Logger;
use Monolog\Processor\GitProcessor;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Processor\GitProcessorFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Processor\GitProcessorFactory
 */
class GitProcessorFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = ['level' => Logger::INFO];

        $factory = new GitProcessorFactory();
        $handler = $factory($options);
        $this->assertInstanceOf(GitProcessor::class, $handler);
    }
}
