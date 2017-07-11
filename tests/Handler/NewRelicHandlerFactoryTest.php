<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\NewRelicHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\NewRelicHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\NewRelicHandlerFactory
 */
class NewRelicHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'level'  => Logger::INFO,
            'bubble' => false,
            'appName' => 'myApp',
            'explodeArrays' => false,
            'transactionName' => 'some-transaction'
        ];

        $factory = new NewRelicHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(NewRelicHandler::class, $handler);
    }
}
