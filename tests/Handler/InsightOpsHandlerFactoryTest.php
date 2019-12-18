<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\InsightOpsHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\InsightOpsHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\InsightOpsHandlerFactory
 */
class InsightOpsHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'token' => 'some-token',
            'region' => 'some-region',
            'useSSL' => false,
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $factory = new InsightOpsHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(InsightOpsHandler::class, $handler);
    }
}
